<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Técnicas - Inazuma Eleven</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">⚽ Proyecto Inazuma</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('jugadores.index') }}">Jugadores</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('equipos.index') }}">Equipos</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('tecnicas.index') }}">Técnicas</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="me-3">
                    <strong>{{ auth()->user()->nombre }}</strong>
                    @if(auth()->user()->esAdmin())
                        <span class="badge bg-danger">Admin</span>
                    @else
                        <span class="badge bg-primary">Usuario</span>
                    @endif
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Técnicas</h1>
        @if(auth()->user()->esAdmin())
            <a href="{{ route('tecnicas.create') }}" class="btn btn-success">+ Nueva Técnica</a>
        @endif
    </div>

    @if(session('mensaje'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($tecnicas as $tecnica)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $tecnica->nombre }}</h5>
                        <p class="card-text text-muted">{{ $tecnica->descripcion }}</p>
                        @if($tecnica->elemento)
                            <span class="badge bg-warning text-dark">{{ $tecnica->elemento->nombre }}</span>
                        @endif
                        @if($tecnica->poder)
                            <span class="badge bg-danger ms-1">Poder: {{ $tecnica->poder }}</span>
                        @endif
                        <p class="mt-2"><strong>{{ $tecnica->jugadores->count() }}</strong> jugadores</p>
                    </div>
                    <div class="card-footer d-flex gap-2">
                        <a href="{{ route('tecnicas.show', $tecnica->id) }}" class="btn btn-primary btn-sm">Ver</a>
                        @if(auth()->user()->esAdmin())
                            <a href="{{ route('tecnicas.edit', $tecnica->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('tecnicas.destroy', $tecnica->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta técnica?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No hay técnicas registradas.</p>
            </div>
        @endforelse
    </div>
</div>
</body>
</html>
