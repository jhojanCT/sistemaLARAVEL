<table class="table">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Fecha y Hora</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salidas as $salida)
        <tr>
            <td>{{ $salida->entradaProduccion->producto->nombre }}</td>
            <td>{{ $salida->cantidad }}</td>
            <td>{{ $salida->fecha_hora_salida }}</td>
            <td>
                <form action="{{ route('salidas_produccion.addToProducts', $salida) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Añadir a Productos</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
