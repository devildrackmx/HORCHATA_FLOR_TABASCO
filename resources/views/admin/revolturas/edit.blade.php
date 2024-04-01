@extends('adminlte::page')

@section('title', 'Revolturas')

@section('content_header')
    <h1>Revolturas</h1>
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
        <h2>Editar Revolturas</h2>
        <form method="post" action="{{ route('admin.revolturas.update', $revoltura->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="fecha_realizacion">Fecha de Realización</label>
                <input type="date" name="fecha_realizacion" class="form-control" value="{{ $revoltura->fecha_realizacion }}">
            </div>
            <div class="form-group">
                <label for="turno">Turno</label>
                {{-- <input type="text" name="turno" class="form-control" value="{{ $revoltura->turno }}"> --}}
                <select name="turno" id="turno" class="form-control">
                    <option value="Matutino" {{ $revoltura->turno === 'Matutino' ? 'selected' : '' }}>Matutino</option>
                    <option value="Vespertino" {{ $revoltura->turno === 'Vespertino' ? 'selected' : '' }}>Vespertino
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="num_revoltura">Número de Revolturas</label>
                <input type="number" name="num_revoltura" class="form-control" value="{{ $revoltura->num_revoltura }}">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
