@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Nuevo Insumo</h1>
@stop

@section('content')

    <div class="container">
        <form method="post" action="{{ route('admin.insumos.store') }}">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
                @error('nombre')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
                @error('descripcion')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="cantidad_disponible">Cantidad Disponible</label>
                <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible">
                @error('cantidad_disponible')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="unidad_medida">Unidad de Medida</label>
                <select id="unidad_medida" name="unidad_medida" class="form-control">
                    <option value="">Seleccione una opción</option>
                    <option value="Kilos">Kilos</option>
                    <option value="Piezas">Piezas</option>
                </select>
                @error('unidad_medida')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" class="form-control">
                @error('stock')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        // Captura el evento de entrada en el campo cantidad_disponible
        document.getElementById('cantidad_disponible').addEventListener('input', function() {
            // Obtiene el valor actual del campo
            let value = this.value;

            // Verifica si el valor contiene un punto decimal
            if (value.includes('.')) {
                // Divide el valor en partes antes y después del punto decimal
                let parts = value.split('.');
                let integerPart = parts[0];
                let decimalPart = parts[1];

                // Limita la parte decimal a un solo dígito
                if (decimalPart && decimalPart.length > 1) {
                    decimalPart = decimalPart.substring(0, 1);
                }

                // Actualiza el valor del campo con la parte entera y la parte decimal limitada
                this.value = integerPart + (decimalPart ? '.' + decimalPart : '');
            }
        });
    </script>
@stop
