<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Técnica</title>
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
    <a href="{{ route('tecnicas.index') }}" class="btn btn-secondary btn-sm mb-3">← Volver a Técnicas</a>
    <h1>Nueva Técnica</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tecnicas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="poder" class="form-label">Poder</label>
            <input type="number" class="form-control" id="poder" name="poder" value="{{ old('poder') }}" min="1" max="9999" placeholder="1 - 9999">
        </div>

        <div class="mb-3">
            <label for="id_elemento" class="form-label">Elemento</label>
            <select class="form-select" id="id_elemento" name="id_elemento">
                <option value="">Sin elemento</option>
                @foreach($elementos as $elemento)
                    <option value="{{ $elemento->id }}" {{ old('id_elemento') == $elemento->id ? 'selected' : '' }}>
                        {{ $elemento->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Crear Técnica</button>
            <a href="{{ route('tecnicas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
