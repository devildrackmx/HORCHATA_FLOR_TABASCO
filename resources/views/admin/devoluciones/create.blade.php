@extends('adminlte::page')

@section('title', 'Devoluciones')

@section('content_header')
    <h1>Devolución</h1>
@stop

@section('content')
    <div class="container">
        <form method="post" action="{{ route('admin.devoluciones.store') }}">
            @csrf
            <div class="form-group">
                <label for="fecha_devolucion">Fecha de Devolución</label>
                <input type="date" class="form-control" id="fecha_devolucion" name="fecha_devolucion">
                @error('fecha_devolucion')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="numero_orden">Número de Orden</label>
                <input type="text" class="form-control" id="numero_orden" name="numero_orden">
                @error('numero_orden')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select class="form-control" id="proveedor_id" name="proveedor_id">
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
                @error('proveedor_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tipo_compra">Tipo de Compra</label>
                <select class="form-control" id="tipo_compra" name="tipo_compra">
                    <option value="CREDITO">Crédito</option>
                    <option value="CONTADO">Contado</option>
                </select>
                @error('tipo_compra')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tipo_moneda">Tipo de Moneda</label>
                <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                    <option value="US">US</option>
                    <option value="MXN">MXN</option>
                </select>
                @error('tipo_moneda')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="iva">IVA (%)</label>
                <input type="number" class="form-control" id="iva" name="iva" step="1" min="0">
                @error('iva')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="insumo_select">Seleccionar Insumo</label>
                <select class="form-control" id="insumo_select">
                    <option value="" disabled selected>Seleccione un insumo</option>
                    @foreach ($insumos as $insumo)
                        <option value="{{ $insumo->id }}" data-unidad-medida="{{ $insumo->unidad_medida }}">
                            {{ $insumo->nombre }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-success mt-2" id="agregar_insumo">Agregar Insumo</button>
            </div>
            <div class="form-group">
                <label for="insumos">Insumos</label>
                <table class="table text-center" id="insumos_table">
                    <!-- Encabezado de la tabla -->
                    <thead>
                        <tr>
                            <th>Insumo</th>
                            <th>Cantidad a devolver</th>
                            <th>Unidad de medida</th>
                            <th>Precio Unitario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <!-- Cuerpo de la tabla -->
                    <tbody>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary">Crear Devolucion</button>
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        // Agregar dinámicamente filas a la tabla
        document.addEventListener('DOMContentLoaded', function() {
            const insumoSelect = document.getElementById('insumo_select');
            const agregarInsumoBtn = document.getElementById('agregar_insumo');
            const insumosTableBody = document.getElementById('insumos_table').getElementsByTagName('tbody')[0];

            agregarInsumoBtn.addEventListener('click', function() {
                const insumoId = insumoSelect.value;
                const insumoNombre = insumoSelect.options[insumoSelect.selectedIndex].text;
                const unidadMedida = insumoSelect.options[insumoSelect.selectedIndex].getAttribute(
                    'data-unidad-medida');

                const cantidadInput = document.createElement('input');
                cantidadInput.type = 'number';
                cantidadInput.name = `insumos[${insumoId}][cantidad]`;
                cantidadInput.className = 'form-control';
                cantidadInput.min = 0;

                const precioInput = document.createElement('input');
                precioInput.type = 'number';
                precioInput.name = `insumos[${insumoId}][precio_unitario]`;
                precioInput.className = 'form-control';
                precioInput.step = 0.01;
                precioInput.min = 0;

                const eliminarBtn = document.createElement('button');
                eliminarBtn.type = 'button';
                eliminarBtn.className = 'btn btn-danger btn-sm';
                eliminarBtn.textContent = 'Eliminar';
                eliminarBtn.addEventListener('click', function() {
                    insumosTableBody.removeChild(row);
                });

                const row = insumosTableBody.insertRow();
                row.innerHTML = `
                <td>${insumoNombre}</td>
                <td></td>
                <td>${unidadMedida}</td>
                <td></td>
                <td></td>`;

                // Agregar inputs a las celdas correspondientes
                row.cells[1].appendChild(cantidadInput);
                row.cells[3].appendChild(precioInput);
                row.cells[4].appendChild(eliminarBtn);
            });
        });
    </script>
@stop
