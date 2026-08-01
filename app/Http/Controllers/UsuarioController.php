<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * CUS02 - Gestionar Usuarios / CUS03 - Asignar Rol a Usuario.
 * CI Listado Usuarios -> CC Usuarios -> CP Usuario / CP Rol -> Usuario / Rol
 */
class UsuarioController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Usuario::class);

        $usuarios = Usuario::with('rol')
            ->when(request('buscar'), fn ($q) => $q->where('nombre', 'like', '%'.request('buscar').'%')
                ->orWhere('correo', 'like', '%'.request('buscar').'%'))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create(): View
    {
        $this->authorize('create', Usuario::class);
        $roles = Rol::orderBy('nombre')->get();

        return view('usuarios.create', compact('roles'));
    }

    public function store(UsuarioRequest $request): RedirectResponse
    {
        $datos = $request->validated();
        $datos['password'] = Hash::make($datos['password']);

        Usuario::create($datos);

        return redirect()->route('usuarios.index')->with('exito', 'Usuario registrado correctamente.');
    }

    public function edit(Usuario $usuario): View
    {
        $this->authorize('update', $usuario);
        $roles = Rol::orderBy('nombre')->get();

        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(UsuarioRequest $request, Usuario $usuario): RedirectResponse
    {
        $datos = $request->validated();

        if (! empty($datos['password'])) {
            $datos['password'] = Hash::make($datos['password']);
        } else {
            unset($datos['password']);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')->with('exito', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario): RedirectResponse
    {
        $this->authorize('delete', $usuario);
        $usuario->update(['activo' => false]);

        return redirect()->route('usuarios.index')->with('exito', 'Usuario inactivado correctamente.');
    }
}
