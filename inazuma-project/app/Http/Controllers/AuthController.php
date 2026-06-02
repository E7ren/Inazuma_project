<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        if (auth()->check()) {
            return redirect()->route('jugadores.index');
        }
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario) {
            // Verificar si es la contraseña sin hashear (para admin123)
            if ($request->password === $usuario->password || Hash::check($request->password, $usuario->password)) {
                Auth::login($usuario);
                return redirect()->route('jugadores.index')->with('mensaje', '¡Bienvenido, ' . $usuario->name . '!');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput();
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('mensaje', 'Sesión cerrada correctamente.');
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Procesar registro
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $usuario = Usuario::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'usuario'
        ]);

        Auth::login($usuario);

        return redirect()->route('jugadores.index')->with('mensaje', '¡Registro exitoso! Bienvenido, ' . $usuario->name);
    }
}
