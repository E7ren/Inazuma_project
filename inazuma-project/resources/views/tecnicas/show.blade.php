<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tecnica->nombre }}</title>
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
    <a href="{{ route('tecnicas.index') }}" class="btn btn-secondary btn-sm mb-3">← Volver</a>

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1>{{ $tecnica->nombre }}</h1>
            <div class="d-flex gap-2 mt-1">
                @if($tecnica->elemento)
                    <span class="badge bg-warning text-dark fs-6">{{ $tecnica->elemento->nombre }}</span>
                @endif
                @if($tecnica->poder)
                    <span class="badge bg-danger fs-6">Poder: {{ $tecnica->poder }}</span>
                @endif
            </div>
        </div>
        @if(auth()->user()->esAdmin())
            <div class="d-flex gap-2">
                <a href="{{ route('tecnicas.edit', $tecnica->id) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('tecnicas.destroy', $tecnica->id) }}" method="POST" onsubmit="return confirm('¿Eliminar técnica?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </div>
        @endif
    </div>

    @if($tecnica->descripcion)
        <p class="lead">{{ $tecnica->descripcion }}</p>
    @endif

    @if(session('mensaje'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Jugadores con esta técnica --}}
        <div class="col-md-8">
            <h3>Jugadores con esta técnica ({{ $tecnica->jugadores->count() }})</h3>
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
                    @forelse($tecnica->jugadores as $jugador)
                        <tr>
                            <td>{{ $jugador->nombre }}</td>
                            <td>{{ $jugador->elemento->nombre ?? '-' }}</td>
                            @if(auth()->user()->esAdmin())
                                <td>
                                    <form action="{{ route('tecnicas.removeJugador', [$tecnica->id, $jugador->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Quitar</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-muted">Ningún jugador tiene esta técnica aún.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Panel añadir jugador (solo admin) --}}
        @if(auth()->user()->esAdmin())
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">Asignar Jugador</div>
                    <div class="card-body">
                        <form action="{{ route('tecnicas.addJugador', $tecnica->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="id_jugador" class="form-label">Selecciona jugador</label>
                                <select class="form-select" name="id_jugador" required>
                                    <option value="">-- Elige un jugador --</option>
                                    @foreach($jugadoresDisponibles as $jugador)
                                        <option value="{{ $jugador->id }}">
                                            {{ $jugador->nombre }} ({{ $jugador->elemento->nombre ?? 'Sin elemento' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Asignar Técnica</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
</body>
</html>
