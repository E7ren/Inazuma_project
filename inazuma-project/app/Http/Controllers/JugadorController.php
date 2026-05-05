<?php

namespace App\Http\Controllers;

use App\Models\Jugador;
use App\Models\MiEquipo;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    public function index()
    {
        $jugadores = Jugador::with(['equipo', 'elemento'])->get();
        return view('jugadores.index', compact('jugadores'));
    }

    public function fichar(Request $request, $id)
    {
        $existe = MiEquipo::where('jugador_id', $id)->exists();

        if (!$existe) {
            MiEquipo::create([
                'jugador_id' => $id
            ]);
            return redirect()->back()->with('mensaje', '¡Jugador fichado con éxito!');
        }

        return redirect()->back()->with('error', 'Este jugador ya está en tu equipo.');
    }
}