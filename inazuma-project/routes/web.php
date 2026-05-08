<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JugadorController;

// Ruta principal - lista de jugadores
Route::get('/', [JugadorController::class, 'index'])->name('jugadores.index');

// Rutas para crear jugador
Route::get('/jugadores/crear', [JugadorController::class, 'create'])->name('jugadores.create');
Route::post('/jugadores', [JugadorController::class, 'store'])->name('jugadores.store');

// Rutas para editar jugador
Route::get('/jugadores/{id}/editar', [JugadorController::class, 'edit'])->name('jugadores.edit');
Route::put('/jugadores/{id}', [JugadorController::class, 'update'])->name('jugadores.update');

// Ruta para eliminar jugador
Route::delete('/jugadores/{id}', [JugadorController::class, 'destroy'])->name('jugadores.destroy');

// Ruta para fichar jugador
Route::post('/fichar/{id}', [JugadorController::class, 'fichar'])->name('jugadores.fichar');

/* Route::get('/', function () {
    return view('welcome');
});*/

