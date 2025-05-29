<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurante;
use App\Models\User;
use App\Models\Mesa;

class RestauranteAdminController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        $user = Auth::user();

        if ($user->restaurante_id === null) {
            // Si no tiene un restaurante asignado, redirigimos o mostramos un error.
            return redirect()->route('index')->with('error', 'No estás asociado a ningún restaurante.');
        }

        // Cargamos la información del restaurante usando la relación definida en el modelo User
        $restaurante = $user->restaurante;

        if (!$restaurante) {
            // En caso de que el restaurante_id exista pero el restaurante haya sido eliminado
            return redirect()->route('home')->with('error', 'El restaurante asociado no se encontró.');
        }

        return view('admin_restaurante.index', compact('restaurante', 'user'));
    }

    /**
     * Muestra el formulario para editar la información del restaurante.
     */
    public function edit()
    {
        $user = Auth::user();

        if ($user->restaurante_id === null) {
            return redirect()->route('home')->with('error', 'No tienes permisos para editar la información de un restaurante.');
        }

        $restaurante = $user->restaurante;

        if (!$restaurante) {
            return redirect()->route('home')->with('error', 'El restaurante asociado no se encontró.');
        }

        return view('admin_restaurante.edit', compact('restaurante'));
    }

    /**
     * Procesa la actualización de la información del restaurante.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->restaurante_id === null) {
            return redirect()->route('home')->with('error', 'No tienes permisos para actualizar la información de un restaurante.');
        }

        $restaurante = $user->restaurante;

        if (!$restaurante) {
            return redirect()->route('home')->with('error', 'El restaurante asociado no se encontró.');
        }

        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'horario' => 'nullable|string|max:255',
            // Añade aquí más reglas de validación para otros campos
        ]);

        // Actualizar los datos del restaurante
        $restaurante->nombre = $request->nombre;
        $restaurante->direccion = $request->direccion;
        $restaurante->telefono = $request->telefono;
        $restaurante->horario = $request->horario;
        // Actualiza otros campos si los tienes

        $restaurante->save();

        return redirect()->route('admin_restaurante.index')->with('success', 'Información del restaurante actualizada correctamente.');
    }

       public function destroyMesa(Mesa $mesa)
    {
        $mesa->delete();
        return redirect()->back()->with('success', 'Mesa eliminada correctamente.');
    }

    /*
    public function showMenus()
    {
        $user = Auth::user();
        if ($user->restaurante_id === null) {
            return redirect()->route('home')->with('error', 'Acceso denegado.');
        }
        $restaurante = $user->restaurante;
        $menus = $restaurante->menus; // Asumiendo que tienes una relación hasMany en Restaurante para 'menus'
        return view('admin_restaurante.menus', compact('menus', 'restaurante'));
    }
    */
}