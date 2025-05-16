<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;

Route::get('restaurantes/{id}/mesas', [ReservaController::class, 'getMesas']);
Route::get('/restaurantes/{id}/reservas', [ReservaController::class, 'getReservas']);
