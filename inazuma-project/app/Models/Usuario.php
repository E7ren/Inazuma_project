<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Verifica si el usuario es administrador
     */
    public function esAdmin()
    {
        return $this->rol === 'admin';
    }

    /**
     * Verifica si el usuario es usuario normal
     */
    public function esUsuario()
    {
        return $this->rol === 'usuario';
    }

    /**
     * Accessor para obtener el nombre (ya que la tabla usa 'name' no 'nombre')
     */
    public function getNombreAttribute()
    {
        return $this->name;
    }
}
