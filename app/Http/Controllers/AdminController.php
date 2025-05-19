<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurante;

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

}
