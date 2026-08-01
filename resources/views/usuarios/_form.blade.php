<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $usuario->nombre ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Apellido</label>
    <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $usuario->apellido ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Correo corporativo</label>
    <input type="email" name="correo" class="form-control" value="{{ old('correo', $usuario->correo ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Contraseña {{ isset($usuario) ? '(dejar en blanco para no cambiar)' : '' }}</label>
    <input type="password" name="password" class="form-control" {{ isset($usuario) ? '' : 'required' }}>
</div>
<div class="mb-3">
    <label class="form-label">Rol asignado</label>
    <select name="rol_id" class="form-select" required>
        <option value="">-- Seleccionar --</option>
        @foreach($roles as $rol)
            <option value="{{ $rol->id }}" @selected(old('rol_id', $usuario->rol_id ?? null) == $rol->id)>{{ $rol->nombre }}</option>
        @endforeach
    </select>
</div>
<div class="form-check mb-3">
    <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo"
        @checked(old('activo', $usuario->activo ?? true))>
    <label class="form-check-label" for="activo">Usuario activo</label>
</div>
