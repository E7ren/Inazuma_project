<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Elemento;
use App\Models\Seleccion;
use App\Models\Equipo;
use App\Models\Jugador;

class InazumaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Elementos (Afinidades)
        $aire = Elemento::create(['nombre' => 'Aire']);
        $bosque = Elemento::create(['nombre' => 'Bosque']);
        $fuego = Elemento::create(['nombre' => 'Fuego']);
        $tierra = Elemento::create(['nombre' => 'Tierra']);

        // 2. Crear Selección
        $japon = Seleccion::create([
            'nombre' => 'Japón',
            'descripcion' => 'Selección nacional de Japón',
            'bandera_url' => 'https://example.com/japon.png'
        ]);

        // 3. Crear Equipo
        $raimon = Equipo::create([
            'nombre' => 'Raimon',
            'descripcion' => 'El legendario equipo del Instituto Raimon',
            'id_seleccion' => $japon->id
        ]);

        // 4. Crear Jugadores de prueba
        Jugador::create([
            'nombre' => 'Mark Evans',
            'descripcion' => 'Capitán y portero legendario.',
            'id_elemento' => $bosque->id,
            'id_equipo' => $raimon->id
        ]);

        Jugador::create([
            'nombre' => 'Axel Blaze',
            'descripcion' => 'El delantero de fuego.',
            'id_elemento' => $fuego->id,
            'id_equipo' => $raimon->id
        ]);

        Jugador::create([
            'nombre' => 'Nathan Swift',
            'descripcion' => 'El defensa más rápido.',
            'id_elemento' => $aire->id,
            'id_equipo' => $raimon->id
        ]);
    }
}