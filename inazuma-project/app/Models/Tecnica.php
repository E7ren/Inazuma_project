<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecnica extends Model
{
    protected $table = 'tecnicas';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'poder',
        'id_elemento'
    ];

    public $timestamps = false;

    /**
     * Relación: Una técnica pertenece a un elemento
     */
    public function elemento()
    {
        return $this->belongsTo(Elemento::class, 'id_elemento');
    }

    /**
     * Relación: Una técnica puede ser usada por muchos jugadores
     */
    public function jugadores()
    {
        return $this->belongsToMany(Jugador::class, 'jugador_tecnica', 'id_tecnica', 'id_jugador');
    }
}
