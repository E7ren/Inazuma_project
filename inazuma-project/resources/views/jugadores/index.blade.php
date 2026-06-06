<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichajes Inazuma Eleven</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>


        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">⚽ Proyecto Inazuma</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('jugadores.index') }}">Jugadores</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('equipos.index') }}">Equipos</a>
                    </li>
                    
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('tecnicas.index') }}">Tecnicas</a>
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













    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Fichajes Inazuma Eleven</h1>
            @if(auth()->user()->esAdmin())
                <a href="{{ route('jugadores.create') }}" class="btn btn-success">Agregar Jugador</a>
            @endif
        </div>
        @if(session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Elemento</th>
                    <th>Equipo Original</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jugadores as $jugador)
                <tr>
                    <td>
                        @if($jugador->imagen_url)
                            <img src="{{ $jugador->imagen_url }}" alt="{{ $jugador->nombre }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                        @else
                            <img src="https://via.placeholder.com/80?text=Sin+Imagen" alt="Sin imagen" style="width: 80px; height: 80px; border-radius: 5px;">
                        @endif
                    </td>
                    <td>{{ $jugador->nombre }}</td>
                    <td>{{ Str::limit($jugador->descripcion, 50) }}</td>
                    <td>{{ $jugador->elemento->nombre }}</td>
                    <td>{{ $jugador->equipo->nombre }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            @if(auth()->user()->esAdmin())
                                <a href="{{ route('jugadores.edit', $jugador->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            @endif
                            <form action="{{ route('jugadores.fichar', $jugador->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Fichar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>