@extends('adminlte::page')

@section('title', 'Crear Envasado')

@section('content_header')
    <h1>Crear Envasado</h1>
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
        <form method="post" action="{{ route('admin.embasados.store') }}">
            @csrf
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" class="form-control">
                @error('fecha')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="turno">Turno:</label>
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
                <label for="presentacion">Presentación de Horchata:</label>
                <select id="selectPresentacion" class="form-control">
                    <option value="default" selected disabled>Seleccionar presentación</option>
                    @foreach ($horchatas as $horchata)
                        <option value="{{ $horchata->id }}">{{ $horchata->presentacion }}</option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="form-group">
                <label for="numCajas">Número de Cajas:</label>
                <input type="number" id="numCajas" name="numCajas" class="form-control" min="0">
            </div> --}}
            {{-- <button type="button" id="addPresentacion" class="btn btn-success">Agregar Presentación</button> --}}

            <h2>Presentaciones de Horchatas:</h2>
            <table class="table" id="presentacionesTable">
                <thead>
                    <tr>
                        <th>Presentación de Horchata</th>
                        <th>Número de Cajas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las filas se agregarán dinámicamente aquí -->
                </tbody>
            </table>
            {{-- <h2>Presentaciones de Horchatas:</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Presentación de Horchata</th>
                        <th>Número de Cajas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($horchatas as $horchata)
                        <tr>
                            <td>{{ $horchata->presentacion }}</td>
                            <td>
                                <input type="number" name="num_cajas[]" class="form-control" min="0">
                                <input type="hidden" name="presentaciones[]" value="{{ $horchata->id }}">
                                @error('num_cajas')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

{{-- @section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var tableBody = $('#presentacionesTable tbody');
            var counter = 0;

            $('#addPresentacion').on('click', function() {
                var presentacionId = $('#selectPresentacion').val();
                var presentacionText = $('#selectPresentacion option:selected').text();
                var numCajas = $('#numCajas').val();

                if (presentacionId && numCajas) {
                    counter++;

                    var newRow = $('<tr id="row_' + counter + '">');
                    newRow.append('<td>' + presentacionText +
                        '<input type="hidden" name="presentaciones[]" value="' + presentacionId +
                        '"></td>');
                    newRow.append('<td>' + numCajas + '<input type="hidden" name="num_cajas[]" value="' +
                        numCajas + '"></td>');
                    newRow.append(
                        '<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(' +
                        counter + ')">Eliminar</button></td>');

                    tableBody.append(newRow);

                    // Limpiar campos después de agregar
                    $('#selectPresentacion').val('default');
                    $('#numCajas').val('');
                }
            });

            // Función para eliminar fila
            window.removeRow = function(rowId) {
                $('#row_' + rowId).remove();
            };
        });
    </script>
@stop --}}
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var tableBody = $('#presentacionesTable tbody');
            var counter = 0;

            $('#selectPresentacion').on('change', function() {
                var presentacionId = $(this).val();
                var presentacionText = $('#selectPresentacion option:selected').text();

                if (presentacionId) {
                    counter++;

                    var newRow = $('<tr id="row_' + counter + '">');
                    newRow.append('<td>' + presentacionText +
                        '<input type="hidden" name="presentaciones[]" value="' + presentacionId +
                        '"></td>');
                    newRow.append(
                        '<td><input type="number" name="num_cajas[]" class="form-control" min="0"></td>'
                        );
                    newRow.append(
                        '<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(' +
                        counter + ')">Eliminar</button></td>');

                    tableBody.append(newRow);

                    // Limpiar el select después de agregar
                    $('#selectPresentacion').val('default');
                }
            });

            // Función para eliminar fila
            window.removeRow = function(rowId) {
                $('#row_' + rowId).remove();
            };
        });
    </script>
@stop
