<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
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

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
