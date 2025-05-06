<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RestauranteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/index', function () {return view('index');})->middleware('auth')->name('index');
Route::get('/home', function () {return view('welcome');})->middleware('auth')->name('home');
Route::get('/logout', function () {auth()->logout();return redirect('/login');})->name('logout');
Route::get('/contact', function () {return view('contact');})->middleware('auth')->name('contact');
Route::post('contact', [ContactController::class, 'sendEmail'])->name('contact.send');
Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes.index');