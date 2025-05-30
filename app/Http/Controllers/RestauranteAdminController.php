<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurante;
use App\Models\User;
use App\Models\Mesa;
use App\Models\Menu;

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

    public function editMesa(Mesa $mesa)
        {
            $user = Auth::user();
            if ($user->restaurante_id === null) {
                return redirect()->route('home')->with('error', 'Acceso denegado.');
            }
            $restaurante = $user->restaurante;
            return view('admin_restaurante.editMesa', compact('mesa', 'restaurante'));
        }
    
    public function updateMesa(Request $request, Mesa $mesa)
    {
        $user = Auth::user();
        if ($user->restaurante_id === null) {
            return redirect()->route('home')->with('error', 'Acceso denegado.');
        }

        $request->validate([
            'capacidad' => 'required|integer|min:1',
        ]);

        $mesa->capacidad = $request->capacidad;

        $mesa->save();

        return redirect()->route('admin_restaurante.index')->with('success', 'Mesa actualizada correctamente.');
    }

    
public function createMesa()
{
    $user = Auth::user();
    if ($user->restaurante_id === null) {
        return redirect()->route('home')->with('error', 'Acceso denegado.');
    }

    $restaurante = $user->restaurante;

    return view('admin_restaurante.createMesa', compact('restaurante'));
}


public function storeMesa(Request $request)
{
    $user = Auth::user();
    if ($user->restaurante_id === null) {
        return redirect()->route('home')->with('error', 'Acceso denegado.');
    }

    $request->validate([
        'capacidad' => 'required|integer|min:1',
    ]);

    // Buscar el último identificador numérico usado (por restaurante si quieres)
    $lastMesa = Mesa::where('restaurante_id', $user->restaurante_id)
                    ->orderByDesc('identificador')
                    ->first();

    // Calcular el siguiente identificador, suponiendo que es un número en string
    if ($lastMesa && is_numeric($lastMesa->identificador)) {
        $nextIdentificador = (int)$lastMesa->identificador + 1;
    } else {
        $nextIdentificador = 1;
    }

    $mesa = new Mesa();
    $mesa->capacidad = $request->capacidad;
    $mesa->restaurante_id = $user->restaurante_id;
    $mesa->identificador = (string)$nextIdentificador;  // convertir a string

    $mesa->save();

    return redirect()->route('admin_restaurante.index')->with('success', 'Mesa creada correctamente.');
}

public function createMenu()
{
    $user = Auth::user();

    if (!$user->restaurante) {
        return redirect()->route('home')->with('error', 'Acceso denegado.');
    }

    return view('admin_restaurante.createMenu', ['restaurante' => $user->restaurante]);
}

public function storeMenu(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'nombre_menu' => 'required|string|max:255',
        'descripcion_menu' => 'nullable|string',
        'precio' => 'required|numeric|min:0',
    ]);

    Menu::create([
        'restaurante_id' => $user->restaurante_id,
        'nombre_menu' => $request->nombre_menu,
        'descripcion_menu' => $request->descripcion_menu,
        'precio' => $request->precio,
    ]);

    return redirect()->route('admin_restaurante.index')->with('success', 'Menú creado correctamente.');
}

public function editMenu(Menu $menu)
{
    $user = Auth::user();

    if ($menu->restaurante_id !== $user->restaurante_id) {
        return redirect()->route('admin_restaurante.index')->with('error', 'Acceso denegado.');
    }

    return view('admin_restaurante.editMenu', compact('menu'));
}

public function updateMenu(Request $request, Menu $menu)
{
    $user = Auth::user();

    if ($menu->restaurante_id !== $user->restaurante_id) {
        return redirect()->route('admin_restaurante.index')->with('error', 'Acceso denegado.');
    }

    $request->validate([
        'nombre_menu' => 'required|string|max:255',
        'descripcion_menu' => 'nullable|string',
        'precio' => 'required|numeric|min:0',
    ]);

    $menu->update([
        'nombre_menu' => $request->nombre_menu,
        'descripcion_menu' => $request->descripcion_menu,
        'precio' => $request->precio,
    ]);

    return redirect()->route('admin_restaurante.index')->with('success', 'Menú actualizado correctamente.');
}


public function destroyMenu(Menu $menu)
{
    $user = Auth::user();

    // Verificar que el menú pertenece al restaurante del usuario
    if ($menu->restaurante_id !== $user->restaurante_id) {
        return redirect()->route('admin_restaurante.index')->with('error', 'Acceso denegado.');
    }

    $menu->delete();

    return redirect()->route('admin_restaurante.index')->with('success', 'Menú eliminado correctamente.');
}

}