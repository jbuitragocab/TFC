<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Restaurante;

class AdminController extends Controller
{
    public function index()
    {
    $restaurantes = Restaurante::all();
    return view('admin.index', compact('restaurantes'));
    }
    
}
