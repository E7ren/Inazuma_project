<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seleccion extends Model
{
    protected $table = 'selecciones';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'bandera_url'
    ];

    public $timestamps = false;

    /**
     * Relación: Una selección tiene muchos equipos
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id_seleccion');
    }
}
