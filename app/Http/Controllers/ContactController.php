<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Enviar el correo cuando se envíe el formulario
    public function sendEmail(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|max:255',
            'telefono' => 'required|max:255',
            'problema' => 'required',
        ]);

        // Recoger los datos del formulario
        $data = [
            'nombre' => $request->input('nombre'),
            'telefono' => $request->input('telefono'),
            'problema' => $request->input('problema'),
        ];

        // Enviar el correo
        Mail::raw(
            "Nombre: {$data['nombre']}\nTeléfono: {$data['telefono']}\nProblema: {$data['problema']}",
            function ($message) {
                $message->to('javierbc2223@gmail.com')
                        ->subject('Contacto de la página web');
            }
        );
        return redirect()->route('contact')->with('success', 'Correo enviado correctamente');
    }
}
