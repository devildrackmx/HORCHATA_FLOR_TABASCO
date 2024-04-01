@extends('adminlte::page')

@section('title', 'Editar Rol')

@section('content_header')
    <h1>Editar Rol</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            {!! Form::model($role, ['route' => ['admin.roles.update', $role], 'method' => 'put']) !!}

            <div class="form-group">
                {!! Form::label('name', 'Nombre') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del Rol']) !!}

                @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <h2>Lista de Permisos</h2>

            @foreach ($permissions as $permission)
                <div>
                    <label>
                        {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-1']) !!}
                        {{ $permission->descripcion }}
                    </label>
                </div>
            @endforeach

            {!! Form::submit('Actualizar Rol', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
