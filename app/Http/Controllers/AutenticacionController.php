<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * CUS01 - Autenticar Usuario.
 * CI Login -> CC Autenticaciones -> CP Usuario / CP Rol -> Usuario / Rol
 */
class AutenticacionController extends Controller
{
    public function mostrarLogin(): View
    {
        return view('auth.login');
    }

    public function mostrarRegistro(): View
    {
        return view('auth.registro');
    }

    public function registrar(RegistroRequest $request): RedirectResponse
    {
        $rol = Rol::where('nombre', Rol::SOLICITANTE_RECURSOS)->firstOrFail();
        $usuario = Usuario::create($request->safe()->except('password_confirmation') + [
            'rol_id' => $rol->id,
            'activo' => true,
        ]);

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('portal.index')->with('exito', 'Cuenta creada correctamente.');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credenciales = $request->validated();

        if (! Auth::attempt($credenciales, $request->boolean('recordar'))) {
            return back()->withErrors([
                'correo' => 'Las credenciales no coinciden con nuestros registros.',
            ])->onlyInput('correo');
        }

        if (! Auth::user()->activo) {
            Auth::logout();
            return back()->withErrors(['correo' => 'El usuario se encuentra inactivo.']);
        }

        $request->session()->regenerate();

        $destino = Auth::user()->tieneRol(Rol::ADMIN_SISTEMA)
            ? route('dashboard')
            : route('portal.index');

        return redirect()->intended($destino);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.index');
    }
}
