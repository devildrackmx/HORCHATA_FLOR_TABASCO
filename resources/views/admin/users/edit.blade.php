@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Correo</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <h4>Lista de Roles</h4>
        {!! Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'put']) !!}
        @foreach ($roles as $role)
            <div>
                <label for="">
                    {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                    {{ $role->name }}
                </label>
            </div>
        @endforeach

        {!! Form::submit('Asignar Rol', ['class' => 'btn btn-primary mt-2']) !!}
        {!! Form::close() !!}
        {{-- <button type="submit" class="btn btn-primary">Actualizar</button> --}}
    </form>
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
