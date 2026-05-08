<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    protected $table = 'jugadores';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen_url',
        'id_elemento',
        'id_equipo'
    ];

    public $timestamps = false;

    /**
     * Relación: Un jugador pertenece a un elemento
     */
    public function elemento()
    {
        return $this->belongsTo(Elemento::class, 'id_elemento');
    }

    /**
     * Relación: Un jugador pertenece a un equipo
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }
}
