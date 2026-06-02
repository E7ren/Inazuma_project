<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar tabla primero (opcional)
        Usuario::truncate();
        
        // Admin
        Usuario::create([
            'name' => 'Efren Andres',
            'email' => 'Efren@IesEnricValor.com',
            'password' => 'admin123', // Sin hashear para facilitar el login
            'rol' => 'admin'
        ]);

        // Usuario 2
        Usuario::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@correo.com',
            'password' => Hash::make('juan123'),
            'rol' => 'usuario'
        ]);

        // Usuario 3
        Usuario::create([
            'name' => 'María García',
            'email' => 'maria@correo.com',
            'password' => Hash::make('maria123'),
            'rol' => 'usuario'
        ]);

        // Super Admin
        Usuario::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@empresa.com',
            'password' => Hash::make('super123'),
            'rol' => 'admin'
        ]);
    }
}
