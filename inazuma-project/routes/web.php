<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\AuthController;

// Rutas de autenticación (públicas)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    
    // Ruta principal - ver jugadores (todos los usuarios autenticados)
    Route::get('/', [JugadorController::class, 'index'])->name('jugadores.index');
    
    // Fichar jugador (todos los usuarios autenticados)
    Route::post('/fichar/{id}', [JugadorController::class, 'fichar'])->name('jugadores.fichar');
    
    // Rutas solo para administradores
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/jugadores/crear', [JugadorController::class, 'create'])->name('jugadores.create');
        Route::post('/jugadores', [JugadorController::class, 'store'])->name('jugadores.store');
        Route::get('/jugadores/{id}/editar', [JugadorController::class, 'edit'])->name('jugadores.edit');
        Route::put('/jugadores/{id}', [JugadorController::class, 'update'])->name('jugadores.update');
        Route::delete('/jugadores/{id}', [JugadorController::class, 'destroy'])->name('jugadores.destroy');
    });
});



