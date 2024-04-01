@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Insumos</h1>
@stop

@section('content')

    <div class="container">
        <h2>Editar Insumo</h2>
        <form method="post" action="{{ route('admin.insumos.update', $insumo->id) }}">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $insumo->nombre }}">
                @error('nombre')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control">{{ $insumo->descripcion }}</textarea>
                @error('descripcion')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- <div class="form-group">
                <label for="cantidad_disponible">Cantidad Disponible</label>
                <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible"
                    value="{{ $insumo->cantidad_disponible }}">
                @error('cantidad_disponible')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div> --}}
            <div class="form-group">
                <label for="cantidad_disponible">Cantidad Disponible</label>
                <input type="text" class="form-control" id="cantidad_disponible" name="cantidad_disponible"
                    value="{{ $insumo->cantidad_disponible }}" step="any" pattern="[0-9]+(\.[0-9]+)?">
                @error('cantidad_disponible')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="unidad_medida">Unidad de Medida</label>
                <select id="unidad_medida" name="unidad_medida" class="form-control">
                    <option value="Kilos" {{ $insumo->unidad_medida == 'Kilos' ? 'selected' : '' }}>Kilos</option>
                    <option value="Piezas" {{ $insumo->unidad_medida == 'Piezas' ? 'selected' : '' }}>Piezas</option>
                </select>
                @error('unidad_medida')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" class="form-control" value="{{ $insumo->stock }}">
                @error('stock')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
    {{-- <script>
        // Captura el evento de entrada en el campo cantidad_disponible
        document.getElementById('cantidad_disponible').addEventListener('input', function() {
            // Obtiene el valor actual del campo
            let value = this.value;

            // Elimina cualquier carácter que no sea un número o un punto decimal
            value = value.replace(/[^0-9.]/g, '');

            // Verifica si el valor contiene más de un punto decimal
            if ((value.match(/\./g) || []).length > 1) {
                // Si hay más de un punto, elimina el último punto
                value = value.slice(0, value.lastIndexOf('.'));
            }

            // Actualiza el valor del campo con los caracteres válidos
            this.value = value;
        });
    </script> --}}
    <script>
        // Captura el evento de entrada en el campo cantidad_disponible
        document.getElementById('cantidad_disponible').addEventListener('input', function() {
            // Obtiene el valor actual del campo
            let value = this.value;

            // Elimina cualquier carácter que no sea un número o un punto decimal
            value = value.replace(/[^0-9.]/g, '');

            // Verifica si el valor contiene más de un punto decimal
            if ((value.match(/\./g) || []).length > 1) {
                // Si hay más de un punto, elimina el último punto
                value = value.slice(0, value.lastIndexOf('.'));
            }

            // Verifica si el valor contiene un punto decimal al final
            if (value.endsWith('.')) {
                return; // No hagas ninguna modificación si el punto está al final
            }

            // Verifica si el valor contiene un punto decimal en cualquier otro lugar
            if (value.includes('.')) {
                // Divide el valor en partes antes y después del punto decimal
                let parts = value.split('.');
                let integerPart = parts[0];
                let decimalPart = parts[1];

                // Limita la parte decimal a tres dígitos
                if (decimalPart && decimalPart.length > 3) {
                    decimalPart = decimalPart.substring(0, 3);
                }

                // Actualiza el valor del campo con la parte entera y la parte decimal limitada
                this.value = integerPart + (decimalPart ? '.' + decimalPart : '');
            } else {
                // Si no hay un punto decimal, asegúrate de que el valor sea un número válido
                this.value = parseFloat(value) || '';
            }
        });
    </script>
@stop
