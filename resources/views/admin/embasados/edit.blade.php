@extends('adminlte::page')

@section('title', 'Editar Embasado')

@section('content_header')
    <h1>Editar Envasado</h1>
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
        <form method="post" action="{{ route('admin.embasados.update', $embasado->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $embasado->fecha) }}">
                @error('fecha')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="turno">Turno:</label>
                {{-- <input type="text" name="turno" class="form-control" value="{{ old('turno', $embasado->turno) }}"> --}}
                <select name="turno" id="turno" class="form-control">
                    <option value="Matutino" {{ $embasado->turno === 'Matutino' ? 'selected' : '' }}>Matutino</option>
                    <option value="Vespertino" {{ $embasado->turno === 'Vespertino' ? 'selected' : '' }}>Vespertino
                    </option>
                </select>
                @error('turno')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- <h2>Presentaciones de Horchatas:</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Presentación de Horchata</th>
                        <th>Número de Cajas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($embasado->horchatas as $horchata)
                        <tr>
                            <td>{{ $horchata->presentacion }}</td>
                            <td>
                                <input type="number" name="num_cajas[]" class="form-control" min="0"
                                    value="{{ old('num_cajas.' . $loop->index, $horchata->pivot->num_cajas) }}">
                                <input type="hidden" name="presentaciones[]" value="{{ $horchata->id }}">
                                @error('num_cajas.' . $loop->index)
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
            <div class="form-group">
                <label for="presentacion">Presentación de Horchata:</label>
                <select id="selectPresentacion" class="form-control">
                    <option value="default" selected disabled>Seleccionar presentación</option>
                    @foreach ($horchatas as $horchata)
                        <option value="{{ $horchata->id }}">{{ $horchata->presentacion }}</option>
                    @endforeach
                </select>
            </div>

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
                    @foreach ($embasado->horchatas as $horchata)
                        <tr>
                            <td>{{ $horchata->presentacion }}</td>
                            <td>
                                <input type="number" name="num_cajas[]" class="form-control" min="0"
                                    value="{{ old('num_cajas.' . $loop->index, $horchata->pivot->num_cajas) }}">
                                <input type="hidden" name="presentaciones[]" value="{{ $horchata->id }}">
                                @error('num_cajas.' . $loop->index)
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td><button type="button" class="btn btn-danger btn-sm"
                                    onclick="removeRow({{ $loop->index + 1 }})">Eliminar</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var tableBody = $('#presentacionesTable tbody');
            var counter =
            {{ count($embasado->horchatas) }}; // Inicializar el contador con el número de filas existentes

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
