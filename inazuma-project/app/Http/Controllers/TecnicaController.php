<?php

namespace App\Http\Controllers;

use App\Models\Tecnica;
use App\Models\Jugador;
use App\Models\Elemento;
use Illuminate\Http\Request;

class TecnicaController extends Controller
{
    public function index()
    {
        $tecnicas = Tecnica::with(['elemento', 'jugadores'])->get();
        return view('tecnicas.index', compact('tecnicas'));
    }

    public function create()
    {
        $elementos = Elemento::all();
        return view('tecnicas.create', compact('elementos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'descripcion'  => 'nullable|string',
            'poder'        => 'nullable|integer|min:1|max:9999',
            'id_elemento'  => 'nullable|exists:elementos,id',
        ]);

        Tecnica::create($request->only(['nombre', 'descripcion', 'poder', 'id_elemento']));

        return redirect()->route('tecnicas.index')->with('mensaje', 'Técnica creada correctamente.');
    }

    public function show($id)
    {
        $tecnica = Tecnica::with(['elemento', 'jugadores.elemento'])->findOrFail($id);
        $idsAsignados = $tecnica->jugadores->pluck('id');
        $jugadoresDisponibles = Jugador::whereNotIn('id', $idsAsignados)->with('elemento')->get();
        return view('tecnicas.show', compact('tecnica', 'jugadoresDisponibles'));
    }

    public function edit($id)
    {
        $tecnica = Tecnica::findOrFail($id);
        $elementos = Elemento::all();
        return view('tecnicas.edit', compact('tecnica', 'elementos'));
    }

    public function update(Request $request, $id)
    {
        $tecnica = Tecnica::findOrFail($id);

        $request->validate([
            'nombre'       => 'required|string|max:100',
            'descripcion'  => 'nullable|string',
            'poder'        => 'nullable|integer|min:1|max:9999',
            'id_elemento'  => 'nullable|exists:elementos,id',
        ]);

        $tecnica->update($request->only(['nombre', 'descripcion', 'poder', 'id_elemento']));

        return redirect()->route('tecnicas.show', $id)->with('mensaje', 'Técnica actualizada correctamente.');
    }

    public function destroy($id)
    {
        $tecnica = Tecnica::findOrFail($id);
        $tecnica->jugadores()->detach();
        $tecnica->delete();

        return redirect()->route('tecnicas.index')->with('mensaje', 'Técnica eliminada correctamente.');
    }

    public function addJugador(Request $request, $id)
    {
        $request->validate(['id_jugador' => 'required|exists:jugadores,id']);

        $tecnica = Tecnica::findOrFail($id);
        $tecnica->jugadores()->syncWithoutDetaching([$request->id_jugador]);

        return redirect()->route('tecnicas.show', $id)->with('mensaje', 'Jugador añadido a la técnica.');
    }

    public function removeJugador($id, $jugadorId)
    {
        $tecnica = Tecnica::findOrFail($id);
        $tecnica->jugadores()->detach($jugadorId);

        return redirect()->route('tecnicas.show', $id)->with('mensaje', 'Jugador quitado de la técnica.');
    }
}
