@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Nuevo Proveedor</h1>
@stop

@section('content')
    <form action="{{ route('admin.proveedores.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Proveedor</label>
            <input type="text" name="nombre" class="form-control">
            @error('nombre')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="calle">Calle</label>
            <input type="text" name="calle" class="form-control">
            @error('calle')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="colonia">Colonia</label>
            <input type="text" name="colonia" class="form-control">
            @error('colonia')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="codigo_postal">Código Postal</label>
            <input type="text" name="codigo_postal" class="form-control">
            @error('codigo_postal')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="ciudad">Ciudad</label>
            <input type="text" name="ciudad" class="form-control">
            @error('ciudad')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" class="form-control">
            @error('telefono')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
