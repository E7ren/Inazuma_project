<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jugador;
use App\Models\Equipo;
use App\Models\Tecnica;

class JugadorApiController extends Controller
{
    /**
     * GET /api/jugadores
     * Devuelve todos los jugadores con su equipo y sus técnicas.
     */
    public function index()
    {
        $jugadores = Jugador::with([
            'elemento',
            'equipo.seleccion',
            'tecnicas.elemento',
        ])->get()->map(function ($jugador) {
            return [
                'id'          => $jugador->id,
                'nombre'      => $jugador->nombre,
                'descripcion' => $jugador->descripcion,
                'imagen_url'  => $jugador->imagen_url,
                'elemento'    => $jugador->elemento?->nombre,
                'equipo'      => $jugador->equipo ? [
                    'id'        => $jugador->equipo->id,
                    'nombre'    => $jugador->equipo->nombre,
                    'seleccion' => $jugador->equipo->seleccion?->nombre,
                ] : null,
                'tecnicas'    => $jugador->tecnicas->map(fn($t) => [
                    'id'       => $t->id,
                    'nombre'   => $t->nombre,
                    'poder'    => $t->poder,
                    'elemento' => $t->elemento?->nombre,
                ]),
            ];
        });

        return response()->json(['data' => $jugadores]);
    }

    /**
     * GET /api/jugadores/{id}
     * Devuelve un jugador concreto con su equipo y sus técnicas.
     */
    public function show($id)
    {
        $jugador = Jugador::with([
            'elemento',
            'equipo.seleccion',
            'tecnicas.elemento',
        ])->findOrFail($id);

        return response()->json([
            'data' => [
                'id'          => $jugador->id,
                'nombre'      => $jugador->nombre,
                'descripcion' => $jugador->descripcion,
                'imagen_url'  => $jugador->imagen_url,
                'elemento'    => $jugador->elemento?->nombre,
                'equipo'      => $jugador->equipo ? [
                    'id'        => $jugador->equipo->id,
                    'nombre'    => $jugador->equipo->nombre,
                    'seleccion' => $jugador->equipo->seleccion?->nombre,
                ] : null,
                'tecnicas'    => $jugador->tecnicas->map(fn($t) => [
                    'id'       => $t->id,
                    'nombre'   => $t->nombre,
                    'poder'    => $t->poder,
                    'elemento' => $t->elemento?->nombre,
                ]),
            ]
        ]);
    }

    /**
     * GET /api/equipos
     * Devuelve todos los equipos con sus jugadores.
     */
    public function equipos()
    {
        $equipos = Equipo::with([
            'seleccion',
            'jugadores.elemento',
            'jugadores.tecnicas',
        ])->get()->map(function ($equipo) {
            return [
                'id'          => $equipo->id,
                'nombre'      => $equipo->nombre,
                'descripcion' => $equipo->descripcion,
                'escudo_url'  => $equipo->escudo_url,
                'seleccion'   => $equipo->seleccion?->nombre,
                'jugadores'   => $equipo->jugadores->map(fn($j) => [
                    'id'       => $j->id,
                    'nombre'   => $j->nombre,
                    'elemento' => $j->elemento?->nombre,
                    'tecnicas' => $j->tecnicas->pluck('nombre'),
                ]),
            ];
        });

        return response()->json(['data' => $equipos]);
    }

    /**
     * GET /api/tecnicas
     * Devuelve todas las técnicas con los jugadores que las usan.
     */
    public function tecnicas()
    {
        $tecnicas = Tecnica::with([
            'elemento',
            'jugadores.elemento',
        ])->get()->map(function ($tecnica) {
            return [
                'id'          => $tecnica->id,
                'nombre'      => $tecnica->nombre,
                'descripcion' => $tecnica->descripcion,
                'poder'       => $tecnica->poder,
                'elemento'    => $tecnica->elemento?->nombre,
                'jugadores'   => $tecnica->jugadores->map(fn($j) => [
                    'id'      => $j->id,
                    'nombre'  => $j->nombre,
                    'elemento'=> $j->elemento?->nombre,
                ]),
            ];
        });

        return response()->json(['data' => $tecnicas]);
    }
}
