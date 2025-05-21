<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {return view('welcome');})->middleware('auth')->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', function () {auth()->logout();return redirect('/login');})->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/index', function () {return view('index');})->middleware('auth')->name('index');
Route::get('/contact', function () {return view('contact');})->middleware('auth')->name('contact')->middleware('auth');
Route::post('contact', [ContactController::class, 'sendEmail'])->name('contact.send');
Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes.index')->middleware('auth');
Route::get('/admin', [LoginController::class, 'adminIndex'])->name('admin.index')->middleware('auth');


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index']); // <-- aquí agregas esta línea
    Route::get('/index', [AdminController::class, 'index'])->name('index');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/', [AdminController::class, 'store'])->name('store');
    Route::delete('/{restaurante}', [AdminController::class, 'destroy'])->name('destroy');
    Route::get('/{restaurante}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/{restaurante}', [AdminController::class, 'update'])->name('update');
    Route::get('/{restaurante}', [AdminController::class, 'show'])->name('show');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/restaurantes/{restaurante}/reservar', [ReservaController::class, 'showBookingForm'])->name('reservas.form');
    Route::post('/reservas/check-availability', [ReservaController::class, 'checkAvailability'])->name('reservas.check_availability');
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/verreservas', [ReservaController::class, 'mostrarReservas'])->name('reservas.show');
    Route::get('/reservas/{id}/edit', [ReservaController::class, 'edit'])->name('reservas.edit');
    Route::put('/reservas/{id}', [ReservaController::class, 'update'])->name('reservas.update');
    Route::delete('/reservas/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy');
});
