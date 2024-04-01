@extends('adminlte::page')

@section('title', 'Nuevo Rol')

@section('content_header')
    <h1>Nuevo Rol</h1>
@stop

@section('content')
    {!! Form::open(['route' => 'admin.roles.store']) !!}
    <div class="form-group">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del Rol']) !!}

        @error('name')
            <small class="text-danger">
                {{$message}}
            </small>
        @enderror
    </div>

    <h2>Lista de Permisos</h2>

    @foreach ($permissions as $permission)
        <div>
            <label>
                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-1 bg-primary']) !!}
                {{$permission->descripcion}}
            </label>
        </div>
    @endforeach

    {!! Form::submit('Crear Rol', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
