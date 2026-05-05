<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\JugadorController;


Route::get('/jugadores', [JugadorController::class, 'index'])->name('jugadores.index');

Route::post('/fichar/{id}', [JugadorController::class, 'fichar'])->name('jugadores.fichar');





Route::get('/', function () {
    return view('welcome');
});
