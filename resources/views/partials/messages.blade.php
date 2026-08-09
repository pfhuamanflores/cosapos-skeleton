@if(session('exito'))
    <div class="app-toast alert alert-success alert-dismissible fade show" role="status"><i class="bi bi-check-circle-fill"></i><span>{{ session('exito') }}</span><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button></div>
@endif
@if($errors->any() && !request()->routeIs('login'))
    <div class="alert alert-danger" role="alert"><div class="fw-semibold mb-1"><i class="bi bi-exclamation-circle me-1"></i>Revisa la información ingresada</div><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
