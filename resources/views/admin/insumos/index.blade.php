@extends('adminlte::page')

@section('title', 'Insumos')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
@endsection

@section('content_header')
    <h1>Insumos</h1>
@stop

@section('content')

    @can('admin.insumos.create')
        <a href="{{ route('admin.insumos.create') }}" class="btn btn-success mb-2">Nuevo Insumo</a>
    @endcan

    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table id="Insumos" class="text-small table table-striped shadow-lg mt-2 text-center">
                            <thead class="bg-primary text-white">
                                <tr class="text-sm">
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Cantidad Disponible</th>
                                    <th>Unidad de Medida</th>
                                    <th>Stock</th>
                                    <th class="no-export">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="text-sm">

                                @foreach ($insumos as $insumo)
                                    <tr>
                                        {{-- <td>{{ $insumo->nombre }}</td>
                                        <td>{{ $insumo->descripcion }}</td>
                                        <td>
                                            @if ($insumo->cantidad_disponible == intval($insumo->cantidad_disponible))
                                                {{ intval($insumo->cantidad_disponible) }}
                                            @else
                                                {{ $insumo->cantidad_disponible }}
                                            @endif
                                        </td>
                                        <td>{{ $insumo->unidad_medida }}</td>
                                        <td>{{ $insumo->stock }}</td> --}}
                                        <td>{{ $insumo->nombre }}</td>
                                        <td>{{ $insumo->descripcion }}</td>
                                        <td>{{ $insumo->cantidad_disponible }}</td>
                                        <td>{{ $insumo->unidad_medida }}</td>
                                        <td>{{ $insumo->stock }}</td>
                                        <td class="no-export">
                                            @can('admin.insumos.edit')
                                                <a href="{{ route('admin.insumos.edit', $insumo->id) }}"
                                                    class="btn btn-warning btn-sm"><i
                                                        class="fa-solid fa-pen-to-square fa-fade"></i></a>
                                            @endcan
                                            @can('admin.insumos.destroy')
                                                <form action="{{ route('admin.insumos.destroy', $insumo->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Estás seguro de eliminar este insumo?')"><i
                                                            class="fa-solid fa-trash fa-fade"></i></button>
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
    <div>
        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
            data-whatever="@mdo">Open modal for @mdo</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
            data-whatever="@fat">Open modal for @fat</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
            data-whatever="@getbootstrap">Open modal for @getbootstrap</button>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-danger">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Recipient:</label>
                                <input type="text" class="form-control" id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Send message</button>
                    </div>
                </div>
            </div>
        </div> --}}
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
            $('#Insumos').DataTable({
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
                        title: 'REPORTE DE INSUMOS',
                        extend: 'excel',
                        text: '<i class="fa-regular fa-file-excel fa-beat"></i> Excel',
                        extension: '.xlsx',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                    {
                        title: 'REPORTE DE INSUMOS',
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf fa-beat"></i> PDF',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                    {
                        title: 'REPORTE DE INSUMOS',
                        extend: 'print',
                        text: '<i class="fa-solid fa-print fa-beat"></i> Imprimir',
                        className: 'btn btn-dark',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                    {
                        title: 'REPORTE DE INSUMOS',
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
