<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos - Inazuma Eleven</title>
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
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('jugadores.index') }}">Jugadores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('equipos.index') }}">Equipos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tecnicas.index') }}">Técnicas</a>
                </li>
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
        <h1>Equipos</h1>
        @if(auth()->user()->esAdmin())
            <a href="{{ route('equipos.create') }}" class="btn btn-success">+ Nuevo Equipo</a>
        @endif
    </div>

    @if(session('mensaje'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($equipos as $equipo)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if($equipo->escudo_url)
                        <img src="{{ $equipo->escudo_url }}" class="card-img-top" style="height:150px;object-fit:contain;padding:10px" alt="{{ $equipo->nombre }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $equipo->nombre }}</h5>
                        <p class="card-text text-muted">{{ $equipo->descripcion }}</p>
                        @if($equipo->seleccion)
                            <span class="badge bg-secondary">{{ $equipo->seleccion->nombre }}</span>
                        @endif
                        <p class="mt-2"><strong>{{ $equipo->jugadores->count() }}</strong> jugadores</p>
                    </div>
                    <div class="card-footer d-flex gap-2">
                        <a href="{{ route('equipos.show', $equipo->id) }}" class="btn btn-primary btn-sm">Ver</a>
                        @if(auth()->user()->esAdmin())
                            <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este equipo?')">
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
                <p class="text-muted">No hay equipos registrados.</p>
            </div>
        @endforelse
    </div>
</div>
</body>
</html>
