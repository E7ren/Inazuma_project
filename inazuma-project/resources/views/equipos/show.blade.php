<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $equipo->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">⚽ Proyecto Inazuma</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto my-2 my-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('jugadores.index') }}">Jugadores</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('equipos.index') }}">Equipos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tecnicas.index') }}">Técnicas</a></li>
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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm mb-2">← Volver</a>
            <h1>{{ $equipo->nombre }}</h1>
            @if($equipo->seleccion)
                <span class="badge bg-secondary fs-6">{{ $equipo->seleccion->nombre }}</span>
            @endif
        </div>
        @if($equipo->escudo_url)
            <img src="{{ $equipo->escudo_url }}" alt="Escudo" style="height:80px;object-fit:contain">
        @endif
    </div>

    @if($equipo->descripcion)
        <p class="lead">{{ $equipo->descripcion }}</p>
    @endif

    @if(session('mensaje'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(auth()->user()->esAdmin())
        <div class="mb-3 d-flex gap-2">
            <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-warning btn-sm">Editar Equipo</a>
            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" onsubmit="return confirm('¿Eliminar equipo?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Eliminar Equipo</button>
            </form>
        </div>
    @endif

    <div class="row">
        {{-- Jugadores del equipo --}}
        <div class="col-md-8">
            <h3>Jugadores del equipo ({{ $equipo->jugadores->count() }})</h3>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Elemento</th>
                        @if(auth()->user()->esAdmin())
                            <th>Acción</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($equipo->jugadores as $jugador)
                        <tr>
                            <td>{{ $jugador->nombre }}</td>
                            <td>{{ $jugador->elemento->nombre ?? '-' }}</td>
                            @if(auth()->user()->esAdmin())
                                <td>
                                    <form action="{{ route('equipos.removeJugador', [$equipo->id, $jugador->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Quitar</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-muted">No hay jugadores en este equipo.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Panel añadir jugador (solo admin) --}}
        @if(auth()->user()->esAdmin())
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">Añadir Jugador</div>
                    <div class="card-body">
                        <form action="{{ route('equipos.addJugador', $equipo->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="id_jugador" class="form-label">Selecciona jugador</label>
                                <select class="form-select" name="id_jugador" required>
                                    <option value="">-- Elige un jugador --</option>
                                    @foreach($jugadoresSinEquipo as $jugador)
                                        <option value="{{ $jugador->id }}">
                                            {{ $jugador->nombre }} ({{ $jugador->elemento->nombre ?? 'Sin elemento' }})
                                            @if($jugador->id_equipo && $jugador->id_equipo != $equipo->id)
                                                — ya en otro equipo
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Añadir al Equipo</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
</body>
</html>
