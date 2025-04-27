<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:usuarios,correo',
            'contrasena' => 'required|string|min:6|confirmed',
            'cuenta_bancaria' => 'required|string|max:20',
        ]);
    
        Usuario::create([
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'correo' => $data['correo'],
            'contrasena' => \Hash::make($data['contrasena']),
            'fecha_registro' => now(),
            'cuenta_bancaria' => $data['cuenta_bancaria'],
        ]);
    
        return redirect()->route('login')->with('success', 'Tu cuenta ha sido creada con éxito. ¡Inicia sesión!');
    }

}
