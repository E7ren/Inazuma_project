<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'escudo_url',
        'id_seleccion'
    ];

    public $timestamps = false;

    /**
     * Relación: Un equipo pertenece a una selección
     */
    public function seleccion()
    {
        return $this->belongsTo(Seleccion::class, 'id_seleccion');
    }

    /**
     * Relación: Un equipo tiene muchos jugadores
     */
    public function jugadores()
    {
        return $this->hasMany(Jugador::class, 'id_equipo');
    }
}
