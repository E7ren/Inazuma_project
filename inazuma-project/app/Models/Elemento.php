<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Elemento extends Model
{
    protected $table = 'elementos';
    
    protected $fillable = [
        'nombre',
        'icono_url'
    ];

    public $timestamps = false;

    /**
     * Relación: Un elemento tiene muchos jugadores
     */
    public function jugadores()
    {
        return $this->hasMany(Jugador::class, 'id_elemento');
    }
}
