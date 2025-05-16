<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;

class ReservaController extends Controller
{

    /**
     * Devuelve JSON con id, identificador y capacidad de cada mesa
     */
    public function getMesas($id)
    {
        $mesas = Mesa::where('restaurante_id', $id)
                     ->orderBy('identificador')
                     ->get(['id','identificador','capacidad']);

        return response()->json($mesas);
    }

    public function storeReserva(Request $request, $restauranteId)
{
    $request->validate([
        'fecha'      => 'required|date',
        'comensales' => 'required|integer|min:1',
        'mesa'       => 'required|exists:mesas,id',
    ]);

    // Comprobamos si ya existe reserva en esa hora + mesa
    $existe = Reserva::where('restaurante_id', $restauranteId)
        ->where('fecha', $request->fecha)
        ->where('mesa_id', $request->mesa)
        ->exists();

    if ($existe) {
        return response()->json([
            'success' => false,
            'message' => 'Esa mesa ya está ocupada en esa franja.'
        ], 409);
    }

    Reserva::create([
        'usuario_id'     => auth()->id(),
        'restaurante_id' => $restauranteId,
        'fecha'          => $request->fecha,
        'num_personas'   => $request->comensales,
        'mesa_id'        => $request->mesa,
        'importe_reserva'=> 0,
    ]);

    return response()->json(['success' => true]);
}

}
