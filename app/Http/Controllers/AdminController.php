<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurante;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Mesa;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function index()
    {
    $restaurantes = Restaurante::all();
    return view('admin.index', compact('restaurantes'));
    }

    public function create()
    {
        return view('admin.create'); // Paso 4
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
        ]);

        Restaurante::create($request->all());

        return redirect()->route('admin.index')->with('success', 'Restaurante creado correctamente.');
    }

    public function destroy($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        $restaurante->delete();

        return redirect()->route('admin.index')->with('success', 'Restaurante eliminado correctamente.');
    }

    public function edit($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        return view('admin.edit', compact('restaurante'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
        ]);

        $restaurante = Restaurante::findOrFail($id);
        $restaurante->update($request->all());

        return redirect()->route('admin.index')->with('success', 'Restaurante actualizado correctamente');
    }

      public function show($id_restaurante)
    {
        $restaurante = Restaurante::where('id_restaurante', $id_restaurante)->firstOrFail();

        return view('admin.show', compact('restaurante'));
    }

    public function mostrarTodasLasReservas()
    {
        $reservas = \App\Models\Reserva::all();

      foreach($reservas as $r){
        $r->restaurante = Restaurante::find($r->restaurante_id);
    }
    foreach($reservas as $r){
        $r->user = User::find($r->usuario_id);
    }


        return view('admin.reservas', compact('reservas'));

    
    }

    public function editReserva($id)
{
    $reserva = Reserva::with('restaurante', 'mesa', 'usuario')->findOrFail($id); // Cargar relaciones necesarias
        $restaurantes = Restaurante::all();
        $mesas = Mesa::all(); 
         $reserva->hora = Carbon::parse($reserva->hora)->format('H:i');
        return view('admin.editareservas', compact('reserva', 'restaurantes', 'mesas'));
}

public function updateReserva(Request $request, $id)
{
     $request->validate([
            'restaurante_id' => 'required|exists:restaurantes,id_restaurante',
            'mesa_id' => 'required|exists:mesas,id',
            'fecha' => 'required|date|after_or_equal:today', // La fecha no puede ser anterior a hoy
            'hora' => 'required|date_format:H:i',
            'num_personas' => 'required|integer|min:1',
            'importe_reserva' => 'nullable|numeric'
        ]);

        $reserva = Reserva::findOrFail($id);
        $mesa = Mesa::findOrFail($request->mesa_id); // Obtener la mesa seleccionada

        // Validar si el número de personas excede la capacidad de la mesa
        if ($request->num_personas > $mesa->capacidad) {
            return back()->withInput()->with('error', 'El número de personas excede la capacidad de la mesa seleccionada (Capacidad: ' . $mesa->capacidad . ').');
        }

        // Actualizar la reserva
        $reserva->update([
            'restaurante_id' => $request->restaurante_id,
            'mesa_id' => $request->mesa_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'num_personas' => $request->num_personas,
            'importe_reserva' => $request->importe_reserva ?? 0,
            // Si el usuario_id se envía como hidden, también se puede actualizar aquí si es necesario
            // 'usuario_id' => $request->usuario_id,
        ]);

    return redirect()->route('admin.reservas')->with('success', 'Reserva actualizada correctamente.');
}

public function destroyReserva($id)
{
    $reserva = \App\Models\Reserva::findOrFail($id);
    $reserva->delete();
    return redirect()->route('admin.reservas')->with('success', 'Reserva eliminada correctamente.');
}
}
