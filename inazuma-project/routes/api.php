<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JugadorApiController;

Route::get('/jugadores',      [JugadorApiController::class, 'index']);
Route::get('/jugadores/{id}', [JugadorApiController::class, 'show']);
Route::get('/equipos',        [JugadorApiController::class, 'equipos']);
Route::get('/tecnicas',       [JugadorApiController::class, 'tecnicas']);
