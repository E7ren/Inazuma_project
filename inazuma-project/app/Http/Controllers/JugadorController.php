<?php

namespace App\Http\Controllers;

use App\Models\Jugador;
use App\Models\Equipo;
use App\Models\Elemento;
use App\Models\MiEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JugadorController extends Controller
{
    public function index()
    {
        $jugadores = Jugador::with(['equipo', 'elemento'])->get();
        return view('jugadores.index', compact('jugadores'));
    }

    public function create()
    {
        $equipos = Equipo::all();
        $elementos = Elemento::all();
        return view('jugadores.create', compact('equipos', 'elementos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'id_elemento' => 'required|exists:elementos,id',
            'id_equipo' => 'required|exists:equipos,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['nombre', 'descripcion', 'id_elemento', 'id_equipo']);

        // Manejar la subida de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $path = $imagen->storeAs('jugadores', $nombreImagen, 'public');
            $data['imagen_url'] = '/storage/' . $path;
        }

        Jugador::create($data);

        return redirect()->route('jugadores.index')->with('mensaje', 'Jugador creado exitosamente');
    }

    public function edit($id)
    {
        $jugador = Jugador::findOrFail($id);
        $equipos = Equipo::all();
        $elementos = Elemento::all();
        return view('jugadores.edit', compact('jugador', 'equipos', 'elementos'));
    }

    public function update(Request $request, $id)
    {
        $jugador = Jugador::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'id_elemento' => 'required|exists:elementos,id',
            'id_equipo' => 'required|exists:equipos,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['nombre', 'descripcion', 'id_elemento', 'id_equipo']);

        // Manejar la subida de imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($jugador->imagen_url) {
                $oldPath = str_replace('/storage/', '', $jugador->imagen_url);
                Storage::disk('public')->delete($oldPath);
            }

            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $path = $imagen->storeAs('jugadores', $nombreImagen, 'public');
            $data['imagen_url'] = '/storage/' . $path;
        }

        $jugador->update($data);

        return redirect()->route('jugadores.index')->with('mensaje', 'Jugador actualizado exitosamente');
    }

    public function destroy($id)
    {
        $jugador = Jugador::findOrFail($id);

        // Eliminar imagen si existe
        if ($jugador->imagen_url) {
            $path = str_replace('/storage/', '', $jugador->imagen_url);
            Storage::disk('public')->delete($path);
        }

        $jugador->delete();

        return redirect()->route('jugadores.index')->with('mensaje', 'Jugador eliminado exitosamente');
    }

    public function fichar(Request $request, $id)
    {
        $existe = MiEquipo::where('id_jugador', $id)->exists();

        if (!$existe) {
            MiEquipo::create([
                'id_jugador' => $id
            ]);
            return redirect()->back()->with('mensaje', '¡Jugador fichado con éxito!');
        }

        return redirect()->back()->with('error', 'Este jugador ya está en tu equipo.');
    }
}