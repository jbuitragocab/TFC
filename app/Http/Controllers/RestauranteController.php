<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestauranteController extends Controller
{
    public function index()
    {
        $restaurantes = Restaurante::with('menu')->get();
        return view('restaurantes.index', compact('restaurantes'));

    }

}