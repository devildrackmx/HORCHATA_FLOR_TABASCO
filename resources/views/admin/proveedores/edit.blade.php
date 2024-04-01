@extends('adminlte::page')

@section('title', 'Editar Proveedor')

@section('content_header')
    <h1>Editar Proveedor</h1>
@stop

@section('content')
    <form action="{{ route('admin.proveedores.update', $proveedore->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Proveedor</label>
            <input type="text" name="nombre" class="form-control" value="{{ $proveedore->nombre }}">
            @error('nombre')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="calle">Calle</label>
            <input type="text" name="calle" class="form-control" value="{{ $proveedore->calle }}">
            @error('calle')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="colonia">Colonia</label>
            <input type="text" name="colonia" class="form-control" value="{{ $proveedore->colonia }}">
            @error('colonia')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="codigo_postal">Código Postal</label>
            <input type="text" name="codigo_postal" class="form-control" value="{{ $proveedore->codigo_postal }}">
            @error('codigo_postal')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="ciudad">Ciudad</label>
            <input type="text" name="ciudad" class="form-control" value="{{ $proveedore->ciudad }}">
            @error('ciudad')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ $proveedore->telefono }}">
            @error('telefono')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
