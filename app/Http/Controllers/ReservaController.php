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

        $restaurante = Restaurante::with('mesas')->findOrFail($request->restaurante_id); // Cargar mesas con el restaurante
        $fechaReserva = Carbon::parse($request->fecha)->format('Y-m-d');
        $horaReserva = $request->hora;
        $numPersonas = $request->num_personas;

        // 2. Obtener las reservas existentes para la fecha y hora dadas en este restaurante
        // Considerar un rango de 2 horas para la ocupación de la mesa
        $horaInicioReserva = Carbon::parse($horaReserva)->subMinutes(120); // 2 horas antes
        $horaFinReserva = Carbon::parse($horaReserva)->addHours(2); // 2 horas después

        $reservasOcupadas = Reserva::where('restaurante_id', $restaurante->id_restaurante)
            ->where('fecha', $fechaReserva)
            ->where(function ($query) use ($horaInicioReserva, $horaFinReserva) {
                // Comprueba si la hora de la reserva existente se solapa con el rango de la nueva reserva
                $query->whereBetween('hora', [$horaInicioReserva->format('H:i:s'), $horaFinReserva->format('H:i:s')])
                      // O si el inicio de la nueva reserva cae dentro de una reserva existente
                      ->orWhere(function ($query) use ($horaInicioReserva) {
                          $query->whereRaw('? BETWEEN hora AND ADDTIME(hora, "02:00:00")', [$horaInicioReserva->format('H:i:s')]);
                      });
            })
            ->pluck('mesa_id');

        // 3. Filtrar las mesas disponibles
        $mesasDisponibles = $restaurante->mesas->filter(function ($mesa) use ($reservasOcupadas, $numPersonas) {
            // La mesa está disponible si no está en las reservas ocupadas Y tiene suficiente capacidad.
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
        try {
            $reserva = \DB::transaction(function () use ($restauranteId, $mesaId, $fechaReserva, $horaReserva, $numPersonas, $request) {
                // 1. Bloqueamos la mesa para evitar que otras reservas la tomen.
                $mesa = Mesa::where('id', $mesaId)->lockForUpdate()->first();

                if (!$mesa) {
                    throw new \Exception('La mesa seleccionada no es válida.');
                }

                // 2. Verificamos la disponibilidad dentro de la transacción.
                $horaInicioReserva = $horaReserva->copy();
                $horaFinReserva = $horaInicioReserva->copy()->addHours(2);

                $mesaOcupada = Reserva::where('restaurante_id', $restauranteId)
                    ->where('mesa_id', $mesaId)
                    ->where('fecha', $fechaReserva)
                    ->where(function ($query) use ($horaInicioReserva, $horaFinReserva) {
                        $query->whereBetween('hora', [$horaInicioReserva->format('H:i:s'), $horaFinReserva->format('H:i:s')])
                              ->orWhere(function ($query) use ($horaInicioReserva) {
                                  $query->whereRaw('? BETWEEN hora AND ADDTIME(hora, "02:00:00")', [$horaInicioReserva->format('H:i:s')]);
                              });
                    })
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

                return $reserva;
            });

            return redirect()->route('reservas.success', $reserva->id)->with('success', '¡Reserva realizada con éxito!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Muestra los detalles de una reserva exitosa.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\View\View
     */
    public function success(Reserva $reserva)
    {
        $reserva->load('restaurante', 'mesa');
        return view('reservas.success', compact('reserva'));
    }

    /**
     * Muestra todas las reservas del usuario autenticado.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function mostrarReservas(): \Illuminate\Contracts\View\View
    {
        // Obtiene todas las reservas del usuario que está autenticado,
        // cargando de forma eficiente las relaciones 'restaurante' y 'mesa'.
        $reservas = Reserva::where('usuario_id', Auth::id())
                          ->with('restaurante', 'mesa') // Eager load relationships
                          ->get();
        //Aqui pillo el nombre del restaurante para mostrarlo en la reserva
        foreach($reservas as $r){
            $r->restaurante = Restaurante::find($r->restaurante_id);
        }
       // var_dump($reservas);
       // exit;
        // Devuelve la vista 'reservas.ver_reservas' y le pasa los datos de las reservas.
        return view('reservas.show', compact('reservas')); // Cambiado a 'reservas.ver_reservas'
    }

    public function edit($id)
    {
        $reserva = Reserva::with('restaurante', 'mesa')->findOrFail($id);
        $restaurantes = \App\Models\Restaurante::all();
        $mesas = \App\Models\Mesa::all();
        return view('reservas.edit', compact('reserva', 'restaurantes', 'mesas'));
    }

    /**
     * Actualiza una reserva en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'restaurante_id' => 'required|exists:restaurantes,id_restaurante',
            'mesa_id' => 'required|exists:mesas,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'num_personas' => 'required|integer|min:1',
        ]);

        $reserva = Reserva::findOrFail($id);
        $reserva->update([
            'restaurante_id' => $request->restaurante_id,
            'mesa_id' => $request->mesa_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'num_personas' => $request->num_personas,
            'importe_reserva' => $request->importe_reserva ?? 0,
        ]);

        return redirect()->route('reservas.show')->with('success', 'Reserva actualizada correctamente.');
    }

    /**
     * Elimina una reserva.
     */
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('reservas.show')->with('success', 'Reserva eliminada correctamente.');
    }
}
