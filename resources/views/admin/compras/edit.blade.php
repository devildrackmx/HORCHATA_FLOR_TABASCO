@extends('adminlte::page')

@section('title', 'Editar Compra')

@section('content_header')
    <h1>Editar Compra</h1>
@stop

@section('content')
    <div class="container">
        <form method="post" action="{{ route('admin.compras.update', $compra->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="fecha_compra">Fecha de Compra</label>
                <input type="date" class="form-control" id="fecha_compra" name="fecha_compra"
                    value="{{ $compra->fecha_compra }}">
                @error('fecha_compra')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="numero_orden">Número de Orden</label>
                <input type="text" class="form-control" id="numero_orden" name="numero_orden"
                    value="{{ $compra->numero_orden }}">
                @error('numero_orden')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select class="form-control" id="proveedor_id" name="proveedor_id">
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}"
                            {{ $compra->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('proveedor_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tipo_compra">Tipo de Compra</label>
                <select class="form-control" id="tipo_compra" name="tipo_compra">
                    <option value="CREDITO" {{ $compra->tipo_compra == 'CREDITO' ? 'selected' : '' }}>Crédito</option>
                    <option value="CONTADO" {{ $compra->tipo_compra == 'CONTADO' ? 'selected' : '' }}>Contado</option>
                </select>
                @error('tipo_compra')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tipo_moneda">Tipo de Moneda</label>
                <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                    <option value="US" {{ $compra->tipo_moneda == 'US' ? 'selected' : '' }}>US</option>
                    <option value="MXN" {{ $compra->tipo_moneda == 'MXN' ? 'selected' : '' }}>MXN</option>
                </select>
                @error('tipo_moneda')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="iva">IVA (%)</label>
                <input type="number" class="form-control" id="iva" name="iva" step="1" min="0"
                    value="{{ $compra->iva }}">
                @error('iva')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campos adicionales según tus necesidades -->

            <div class="form-group">
                <label for="insumos">Insumos</label>
                <table class="table text-center" id="insumos_table">
                    <!-- Encabezado de la tabla -->
                    <thead>
                        <tr>
                            <th>Insumo</th>
                            <th>Cantidad a comprar</th>
                            <th>Unidad de medida</th>
                            <th>Precio Unitario</th>
                        </tr>
                    </thead>
                    <!-- Cuerpo de la tabla -->
                    <tbody>
                        @foreach ($compra->insumos as $insumo)
                            <tr>
                                <td>{{ $insumo->nombre }}</td>
                                <td>
                                    <input type="number" class="form-control"
                                        name="insumos[{{ $insumo->id }}][cantidad]"
                                        value="{{ $insumo->pivot->cantidad }}">
                                </td>
                                <td>{{ $insumo->unidad_medida }}</td>
                                <td>
                                    <input type="number" class="form-control"
                                        name="insumos[{{ $insumo->id }}][precio_unitario]" step="0.01" min="0"
                                        value="{{ $insumo->pivot->precio_unitario }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar compra</button>
            </div>
        </form>
    </div>
@stop
