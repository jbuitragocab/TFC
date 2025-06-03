<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Models\Restaurante;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Para trabajar con fechas y horas fácilmente
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse; // Para manejar redirecciones
use Illuminate\View\View; // Para manejar vistas


class OpinionController extends Controller
{
    /**
     *
     * @param  \App\Models\Restaurante  $restaurante
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Restaurante $restaurante)
    {
        // Verificar si el usuario ya ha dejado una opinión para este restaurante
        $existingOpinion = Opinion::where('usuario_id', Auth::id())
                                  ->where('restaurante_id', $restaurante->id_restaurante)
                                  ->first();

        if ($existingOpinion) {
            return redirect()->route('reservas.show')->with('info', 'Ya has dejado una opinión para este restaurante.');
        }
        return view('opiniones.create', compact('restaurante'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'restaurante_id' => 'required|exists:restaurantes,id_restaurante',
            'comentario' => 'nullable|string|max:1000',
            'calificacion' => 'required|integer|min:1|max:5', // Calificación de 1 a 5
        ]);

        // Prevenir que un usuario deje múltiples opiniones para el mismo restaurante
        $existingOpinion = Opinion::where('usuario_id', Auth::id())
                                  ->where('restaurante_id', $request->restaurante_id)
                                  ->first();

        if ($existingOpinion) {
            return back()->with('error', 'Ya has dejado una opinión para este restaurante.');
        }

        Opinion::create([
            'usuario_id' => Auth::id(),
            'restaurante_id' => $request->restaurante_id,
            'comentario' => $request->comentario,
            'calificacion' => $request->calificacion,
            'fecha' => Carbon::now()->format('Y-m-d'), // Guardar la fecha actual de la opinión
        ]);

        return redirect()->route('reservas.show')->with('success', '¡Gracias por tu opinión!');
    }
}