<!-- resources/views/jugadores/index.blade.php -->
<h1>Fichajes Inazuma Eleven</h1>

@if(session('mensaje'))
    <p style="color: green;">{{ session('mensaje') }}</p>
@endif

<table border="1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Elemento</th>
            <th>Equipo Original</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jugadores as $jugador)
        <tr>
            <td>{{ $jugador->nombre }}</td>
            <td>{{ $jugador->elemento->nombre }}</td>
            <td>{{ $jugador->equipo->nombre }}</td>
            <td>
                <form action="{{ route('jugadores.fichar', $jugador->id) }}" method="POST">
                    @csrf
                    <button type="submit">Fichar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>