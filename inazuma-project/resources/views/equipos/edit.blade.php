<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Editar Equipo: {{ $equipo->nombre }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('equipos.update', $equipo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $equipo->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $equipo->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="escudo" class="form-label">Escudo del Equipo</label>
            @if($equipo->escudo_url)
                <div class="mb-2">
                    <img src="{{ $equipo->escudo_url }}" alt="Escudo actual" style="height:60px;object-fit:contain">
                    <small class="text-muted ms-2">Escudo actual</small>
                </div>
            @endif
            <input type="file" class="form-control" id="escudo" name="escudo" accept="image/*">
            <small class="form-text text-muted">Deja vacío para mantener el escudo actual. Máximo 2MB.</small>
        </div>

        <div class="mb-3">
            <label for="id_seleccion" class="form-label">Selección</label>
            <select class="form-select" id="id_seleccion" name="id_seleccion">
                <option value="">Sin selección</option>
                @foreach($selecciones as $seleccion)
                    <option value="{{ $seleccion->id }}" {{ old('id_seleccion', $equipo->id_seleccion) == $seleccion->id ? 'selected' : '' }}>
                        {{ $seleccion->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning">Guardar Cambios</button>
            <a href="{{ route('equipos.show', $equipo->id) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
