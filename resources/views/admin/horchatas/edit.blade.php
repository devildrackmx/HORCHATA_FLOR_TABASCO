@extends('adminlte::page')

@section('title', 'Crear Cliente')

@section('content_header')
    <h1>Crear Cliente</h1>
@stop

@section('content')

    <div class="container">
        <form method="post" action="{{ route('admin.horchatas.update', $horchata->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="presentacion">Presentación</label>
                <input type="text" class="form-control" id="presentacion" name="presentacion"
                    value="{{ $horchata->presentacion }}">
                @error('presentacion')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
