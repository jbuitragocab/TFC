<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'correo' => 'required|string|email|max:255|unique:users,correo',
            'password' => 'required|string|min:6|confirmed',
            'cuenta_bancaria' => 'required|string|max:20',
        ]);
    
        User::create([
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'correo' => $data['correo'],
            'password' => \Hash::make($data['password']),
            'fecha_registro' => now(),
            'cuenta_bancaria' => $data['cuenta_bancaria'],
        ]);
    
        return redirect()->route('login')->with('success', 'Tu cuenta ha sido creada con éxito. ¡Inicia sesión!');
    }

}
