@extends('adminlte::page')

@section('title', 'Nuevo Usuario')

@section('content_header')
    <h1>Nuevo Usuario</h1>
@stop

@section('content')
    {!! Form::open(['route' => 'admin.users.store']) !!}
    <div class="form-group">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del Rol']) !!}

        @error('name')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror
    </div>
    <div class="form-group">
        {!! Form::label('email', 'Correo') !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese un correo Electronico']) !!}
        @error('email')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror
    </div>

    {{-- <h2>Lista de Permisos</h2>

    @foreach ($permissions as $permission)
        <div>
            <label>
                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-1 bg-primary']) !!}
                {{ $permission->descripcion }}
            </label>
        </div>
    @endforeach --}}

    {!! Form::submit('Crear Usuario', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
