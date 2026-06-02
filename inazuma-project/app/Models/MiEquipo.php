<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiEquipo extends Model
{
    protected $table = 'mi_equipo';
    
    protected $fillable = [
        'id_jugador',
        'fecha_fichaje'
    ];

    public $timestamps = false;

    /**
     * Relación: Mi equipo tiene un jugador
     */
    public function jugador()
    {
        return $this->belongsTo(Jugador::class, 'id_jugador');
    }
}
