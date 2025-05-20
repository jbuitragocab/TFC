<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Restaurante;
use App\Models\Mesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Para trabajar con fechas y horas fácilmente
use Illuminate\View\View;

class ReservaController extends Controller
{
    /**
     * Muestra el formulario para buscar mesas disponibles y hacer una reserva.
     * @param int $id_restaurante
     * @return \Illuminate\View\View
     */
    public function showBookingForm(Restaurante $restaurante)
    {
        return view('reservas.book', compact('restaurante'));
    }

    /**
     * Busca mesas disponibles para un restaurante, fecha y hora específicos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'restaurante_id' => 'required|exists:restaurantes,id_restaurante',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'num_personas' => 'required|integer|min:1',
        ]);

        $restaurante = Restaurante::findOrFail($request->restaurante_id);
        $fechaReserva = Carbon::parse($request->fecha)->format('Y-m-d');
        $horaReserva = $request->hora;
        $numPersonas = $request->num_personas;

        // 1. Obtener todas las mesas del restaurante
        // Asegúrate de que las mesas se carguen con el restaurante.
        $mesasDelRestaurante = $restaurante->mesas;

        // 2. Obtener las reservas existentes para la fecha y hora dadas en este restaurante
        $horaInicioReserva = Carbon::parse($horaReserva)->subMinutes(120);
        $horaFinReserva = Carbon::parse($horaReserva)->addHours(2);

        $reservasOcupadas = Reserva::where('restaurante_id', $restaurante->id_restaurante)
            ->where('fecha', $fechaReserva)
            ->whereBetween('hora', [$horaInicioReserva->format('H:i:s'), $horaFinReserva->format('H:i:s')])
            ->pluck('mesa_id');

        // 3. Filtrar las mesas disponibles
        $mesasDisponibles = $mesasDelRestaurante->filter(function ($mesa) use ($reservasOcupadas, $numPersonas) {
            // La mesa está disponible si no está en las reservas ocupadas y tiene suficiente capacidad.
            return !$reservasOcupadas->contains($mesa->id) && $mesa->capacidad >= $numPersonas;
        });

        if ($request->ajax()) {
            return response()->json([
                'mesas' => $mesasDisponibles->values()->all(), // Convertir a array indexado
                'restaurante' => $restaurante,
                'fecha' => $fechaReserva,
                'hora' => $horaReserva,
                'num_personas' => $numPersonas,
            ]);
        }

        return view('reservas.available_tables', compact('restaurante', 'mesasDisponibles', 'fechaReserva', 'horaReserva', 'numPersonas'));
    }

    /**
     * Crea una nueva reserva.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
      public function store(Request $request)
    {
        $request->validate([
            'restaurante_id' => 'required|exists:restaurantes,id_restaurante',
            'mesa_id' => 'required|exists:mesas,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'num_personas' => 'required|integer|min:1',
        ]);

        $fechaReserva = Carbon::parse($request->fecha)->format('Y-m-d');
        $horaReserva = Carbon::parse($request->hora);
        $numPersonas = $request->num_personas;
        $restauranteId = $request->restaurante_id;
        $mesaId = $request->mesa_id;

        // Usamos una transacción para asegurar la atomicidad de la operación.
        return \DB::transaction(function () use ($restauranteId, $mesaId, $fechaReserva, $horaReserva, $numPersonas, $request) {
            // 1. Bloqueamos la mesa para evitar que otras reservas la tomen.
            $mesa = Mesa::where('id', $mesaId)->lockForUpdate()->first();

            // 2. Verificamos la disponibilidad dentro de la transacción.
            $horaInicioReserva = $horaReserva->copy();
            $horaFinReserva = $horaInicioReserva->copy()->addHours(2);

            $mesaOcupada = Reserva::where('restaurante_id', $restauranteId)
                ->where('mesa_id', $mesaId)
                ->where('fecha', $fechaReserva)
                ->whereBetween('hora', [$horaInicioReserva->format('H:i:s'), $horaFinReserva->format('H:i:s')])
                ->exists();

            if ($mesaOcupada) {
                throw new \Exception('La mesa seleccionada ya no está disponible para esa fecha y hora. Por favor, elige otra.');
            }

            if ($mesa->capacidad < $numPersonas) {
                throw new \Exception('La mesa seleccionada no tiene capacidad suficiente para el número de personas indicada.');
            }

            // 3. Si la mesa está disponible, creamos la reserva.
            $reserva = Reserva::create([
                'usuario_id' => Auth::id(),
                'restaurante_id' => $restauranteId,
                'mesa_id' => $mesaId,
                'fecha' => $fechaReserva,
                'hora' => $horaReserva->format('H:i:s'),
                'num_personas' => $numPersonas,
                'importe_reserva' => $request->importe_reserva ?? 0,
                'estado' => 'confirmada',
            ]);

            // No necesitamos confirmar la transacción; Laravel lo hace automáticamente al final del closure.
            return $reserva; // Puedes devolver la reserva creada si lo necesitas
        });

        // Si la transacción se completa con éxito, redirigimos.
        return redirect()->route('reservas.success')->with('success', '¡Reserva realizada con éxito!');
    }

    /**
     * Muestra todas las reservas del usuario autenticado.
     *
     * @return \Illuminate\Contracts\View\View
     */
      public function mostrarReservas(): \Illuminate\Contracts\View\View
    {
        // Obtiene todas las reservas del usuario que está autenticado.
        $reservas = Reserva::where('usuario_id', Auth::id())->get();

        // Carga las relaciones 'restaurante' y 'mesa' para cada reserva.
        // Esto es crucial para acceder a los datos del restaurante y la mesa.
        foreach ($reservas as $reserva) {
            $reserva->load('restaurante', 'mesa');
        }

        // Devuelve la vista 'reservas.ver_reservas' y le pasa los datos de las reservas.
        // Asegúrate de crear esta vista en resources/views/reservas/ver_reservas.blade.php
        return view('reservas.show', compact('reservas'));
    }
}

