<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Técnica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Editar Técnica: {{ $tecnica->nombre }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tecnicas.update', $tecnica->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $tecnica->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $tecnica->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="poder" class="form-label">Poder</label>
            <input type="number" class="form-control" id="poder" name="poder" value="{{ old('poder', $tecnica->poder) }}" min="1" max="9999">
        </div>

        <div class="mb-3">
            <label for="id_elemento" class="form-label">Elemento</label>
            <select class="form-select" id="id_elemento" name="id_elemento">
                <option value="">Sin elemento</option>
                @foreach($elementos as $elemento)
                    <option value="{{ $elemento->id }}" {{ old('id_elemento', $tecnica->id_elemento) == $elemento->id ? 'selected' : '' }}>
                        {{ $elemento->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning">Guardar Cambios</button>
            <a href="{{ route('tecnicas.show', $tecnica->id) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
