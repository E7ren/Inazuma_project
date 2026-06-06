<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Seleccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::with(['seleccion', 'jugadores'])->get();
        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        $selecciones = Seleccion::all();
        return view('equipos.create', compact('selecciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'descripcion'  => 'nullable|string',
            'escudo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_seleccion' => 'nullable|exists:selecciones,id',
        ]);

        $data = $request->only(['nombre', 'descripcion', 'id_seleccion']);

        if ($request->hasFile('escudo')) {
            $path = $request->file('escudo')->store('equipos', 'public');
            $data['escudo_url'] = '/storage/' . $path;
        }

        Equipo::create($data);

        return redirect()->route('equipos.index')->with('mensaje', 'Equipo creado correctamente.');
    }

    public function show($id)
    {
        $equipo = Equipo::with(['seleccion', 'jugadores.elemento'])->findOrFail($id);
        $jugadoresSinEquipo = Jugador::whereNull('id_equipo')
                                     ->orWhere('id_equipo', '!=', $id)
                                     ->with('elemento')
                                     ->get();
        return view('equipos.show', compact('equipo', 'jugadoresSinEquipo'));
    }

    public function edit($id)
    {
        $equipo = Equipo::findOrFail($id);
        $selecciones = Seleccion::all();
        return view('equipos.edit', compact('equipo', 'selecciones'));
    }

    public function update(Request $request, $id)
    {
        $equipo = Equipo::findOrFail($id);

        $request->validate([
            'nombre'       => 'required|string|max:100',
            'descripcion'  => 'nullable|string',
            'escudo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_seleccion' => 'nullable|exists:selecciones,id',
        ]);

        $data = $request->only(['nombre', 'descripcion', 'id_seleccion']);

        if ($request->hasFile('escudo')) {
            if ($equipo->escudo_url) {
                $oldPath = str_replace('/storage/', '', $equipo->escudo_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('escudo')->store('equipos', 'public');
            $data['escudo_url'] = '/storage/' . $path;
        }

        $equipo->update($data);

        return redirect()->route('equipos.show', $id)->with('mensaje', 'Equipo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        // Desasignar jugadores antes de eliminar
        Jugador::where('id_equipo', $id)->update(['id_equipo' => null]);
        $equipo->delete();

        return redirect()->route('equipos.index')->with('mensaje', 'Equipo eliminado correctamente.');
    }

    public function addJugador(Request $request, $id)
    {
        $request->validate(['id_jugador' => 'required|exists:jugadores,id']);

        $jugador = Jugador::findOrFail($request->id_jugador);
        $jugador->update(['id_equipo' => $id]);

        return redirect()->route('equipos.show', $id)->with('mensaje', 'Jugador añadido al equipo.');
    }

    public function removeJugador($id, $jugadorId)
    {
        $jugador = Jugador::findOrFail($jugadorId);
        $jugador->update(['id_equipo' => null]);

        return redirect()->route('equipos.show', $id)->with('mensaje', 'Jugador quitado del equipo.');
    }
}
