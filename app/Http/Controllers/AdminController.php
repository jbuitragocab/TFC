<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurante;
use App\Models\Reserva;
use App\Models\User;


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
        $reservas = \App\Models\Reserva::all(); // Asegúrate de tener el modelo Reserva

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
    $reserva = \App\Models\Reserva::findOrFail($id);
    $restaurantes = \App\Models\Restaurante::all();
    $usuarios = \App\Models\User::all();
    // Si tienes modelo Mesa:
    $mesas = \App\Models\Mesa::all();
    return view('admin.editareservas', compact('reserva', 'restaurantes', 'usuarios', 'mesas'));
}

public function updateReserva(Request $request, $id)
{
    $request->validate([
        'restaurante_id' => 'required|exists:restaurantes,id_restaurante',
        'usuario_id' => 'required|exists:users,id_usuario',
        'mesa_id' => 'required|exists:mesas,id',
        'fecha' => 'required|date',
        'hora' => 'required',
        'num_personas' => 'required|integer|min:1',
        'importe_reserva' => 'nullable|numeric'
    ]);

    $reserva = \App\Models\Reserva::findOrFail($id);
    $reserva->update($request->all());

    return redirect()->route('admin.reservas')->with('success', 'Reserva actualizada correctamente.');
}

public function destroyReserva($id)
{
    $reserva = \App\Models\Reserva::findOrFail($id);
    $reserva->delete();
    return redirect()->route('admin.reservas')->with('success', 'Reserva eliminada correctamente.');
}
}
