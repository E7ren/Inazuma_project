<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\TecnicaController;
use App\Http\Controllers\AuthController;

// Rutas de autenticación (públicas)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {

    // Jugadores
    Route::get('/', [JugadorController::class, 'index'])->name('jugadores.index');
    Route::post('/fichar/{id}', [JugadorController::class, 'fichar'])->name('jugadores.fichar');

    // Equipos (rutas estáticas ANTES que las dinámicas)
    Route::get('/equipos', [EquipoController::class, 'index'])->name('equipos.index');

    // Técnicas (rutas estáticas ANTES que las dinámicas)
    Route::get('/tecnicas', [TecnicaController::class, 'index'])->name('tecnicas.index');

    // Rutas solo para administradores
    Route::middleware(['role:admin'])->group(function () {

        // Jugadores admin
        Route::get('/jugadores/crear', [JugadorController::class, 'create'])->name('jugadores.create');
        Route::post('/jugadores', [JugadorController::class, 'store'])->name('jugadores.store');
        Route::get('/jugadores/{id}/editar', [JugadorController::class, 'edit'])->name('jugadores.edit');
        Route::put('/jugadores/{id}', [JugadorController::class, 'update'])->name('jugadores.update');
        Route::delete('/jugadores/{id}', [JugadorController::class, 'destroy'])->name('jugadores.destroy');

        // Equipos admin (estáticas primero, dinámicas después)
        Route::get('/equipos/crear', [EquipoController::class, 'create'])->name('equipos.create');
        Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');
        Route::get('/equipos/{id}', [EquipoController::class, 'show'])->name('equipos.show');
        Route::get('/equipos/{id}/editar', [EquipoController::class, 'edit'])->name('equipos.edit');
        Route::put('/equipos/{id}', [EquipoController::class, 'update'])->name('equipos.update');
        Route::delete('/equipos/{id}', [EquipoController::class, 'destroy'])->name('equipos.destroy');
        Route::post('/equipos/{id}/jugadores', [EquipoController::class, 'addJugador'])->name('equipos.addJugador');
        Route::delete('/equipos/{id}/jugadores/{jugadorId}', [EquipoController::class, 'removeJugador'])->name('equipos.removeJugador');

        // Técnicas admin (estáticas primero, dinámicas después)
        Route::get('/tecnicas/crear', [TecnicaController::class, 'create'])->name('tecnicas.create');
        Route::post('/tecnicas', [TecnicaController::class, 'store'])->name('tecnicas.store');
        Route::get('/tecnicas/{id}', [TecnicaController::class, 'show'])->name('tecnicas.show');
        Route::get('/tecnicas/{id}/editar', [TecnicaController::class, 'edit'])->name('tecnicas.edit');
        Route::put('/tecnicas/{id}', [TecnicaController::class, 'update'])->name('tecnicas.update');
        Route::delete('/tecnicas/{id}', [TecnicaController::class, 'destroy'])->name('tecnicas.destroy');
        Route::post('/tecnicas/{id}/jugadores', [TecnicaController::class, 'addJugador'])->name('tecnicas.addJugador');
        Route::delete('/tecnicas/{id}/jugadores/{jugadorId}', [TecnicaController::class, 'removeJugador'])->name('tecnicas.removeJugador');
    });
});

