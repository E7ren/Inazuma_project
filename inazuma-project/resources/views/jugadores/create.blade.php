<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Jugador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Crear Nuevo Jugador</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jugadores.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="id_elemento" class="form-label">Elemento</label>
                <select class="form-select" id="id_elemento" name="id_elemento" required>
                    <option value="">Selecciona un elemento</option>
                    @foreach($elementos as $elemento)
                        <option value="{{ $elemento->id }}" {{ old('id_elemento') == $elemento->id ? 'selected' : '' }}>
                            {{ $elemento->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_equipo" class="form-label">Equipo</label>
                <select class="form-select" id="id_equipo" name="id_equipo" required>
                    <option value="">Selecciona un equipo</option>
                    @foreach($equipos as $equipo)
                        <option value="{{ $equipo->id }}" {{ old('id_equipo') == $equipo->id ? 'selected' : '' }}>
                            {{ $equipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Jugador</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                <small class="form-text text-muted">Formatos permitidos: jpeg, png, jpg, gif. Máximo 2MB.</small>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Crear Jugador</button>
                <a href="{{ route('jugadores.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
