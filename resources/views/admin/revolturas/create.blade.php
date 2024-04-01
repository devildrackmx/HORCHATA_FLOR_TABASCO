@extends('adminlte::page')

@section('title', 'Revoltura')

@section('content_header')
    <h1>Nueva Revoltura</h1>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <form method="post" action="{{ route('admin.revolturas.store') }}">
            @csrf
            <div class="form-group">
                <label for="fecha_realizacion">Fecha de Realización</label>
                <input type="date" name="fecha_realizacion" class="form-control">
                @error('fecha_realizacion')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="turno">Turno</label>
                {{-- <input type="text" name="turno" class="form-control"> --}}
                <select id="turno" name="turno" class="form-control">
                    <option value="default" selected disabled>Seleccionar turno</option>
                    <option value="Matutino" @if (old('turno') == 'Matutino') selected @endif>Matutino</option>
                    <option value="Vespertino" @if (old('turno') == 'Vespertino') selected @endif>Vespertino</option>
                </select>
                @error('turno')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="num_revoltura">Número de Revolturas</label>
                <input type="number" name="num_revoltura" class="form-control">
                @error('num_revolturas')
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
@stop
