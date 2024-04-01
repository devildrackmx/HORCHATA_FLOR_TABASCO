@extends('adminlte::page')

@section('title', 'Envasados')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
@endsection

@section('content_header')
    <h1>Envasados</h1>
@stop

@section('content')

    @can('admin.embasados.create')
        <a href="{{ route('admin.embasados.create') }}" class="btn btn-success mb-2">Crear envasado</a>
    @endcan

    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table id="Embasados" class="table table-striped shadow-lg mt-4">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Turno</th>
                                    <th>No. Cajas</th>
                                    <th class="no-export">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($embasados as $embasado)
                                    <tr>
                                        <td>{{ $embasado->fecha }}</td>
                                        <td>{{ $embasado->turno }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($embasado->horchatas as $horchata)
                                                    <li>{{ $horchata->presentacion }} ({{ $horchata->pivot->num_cajas }}
                                                        cajas)</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="no-export">
                                            @can('admin.embasados.edit')
                                                <a href="{{ route('admin.embasados.edit', $embasado->id) }}"
                                                    class="btn btn-info btn-sm">Editar</a>
                                            @endcan
                                            @can('admin.embasados.destroy')
                                                <form action="{{ route('admin.embasados.destroy', $embasado->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Estás seguro de eliminar este envasado?')">Eliminar</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://kit.fontawesome.com/1bd562e622.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>t>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#Embasados').DataTable({
                responsive: true,
                autoWidth: false,
                dom: 'lBfrtip',
                lengthMenu: [10, 20, 50, 100],
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "emptyTable": "No hay datos disponibles en la tabla",
                buttons: [{
                        title: 'REPORTE DE EMBASADOS',
                        extend: 'excel',
                        text: '<i class="fa-regular fa-file-excel fa-beat"></i> Excel',
                        extension: '.xlsx',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                    {
                        title: 'REPORTE DE EMBASADOS',
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf fa-beat"></i> PDF',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                    {
                        title: 'REPORTE DE EMBASADOS',
                        extend: 'print',
                        text: '<i class="fa-regular fa-file-excel fa-beat"></i> Imprimir',
                        className: 'btn btn-dark',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                    {
                        title: 'REPORTE DE EMBASADOS',
                        extend: 'copy',
                        text: '<i class="fa-solid fa-copy fa-beat"></i> Copiar todo',
                        className: 'btn btn-light',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                ],
            });
        });
    </script>
@endsection
