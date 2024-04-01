@extends('adminlte::page')

@section('title', 'Compras')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
@endsection

@section('content_header')
    <h1>Compras</h1>
@stop

@section('content')
    @can('admin.compras.create')
        <a href="{{ route('admin.compras.create') }}" class="btn btn-success mb-2">Nueva compra</a>
    @endcan
    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table id="Compras" class="table table-striped shadow-lg mt-2 text-center">
                            <thead class="bg-primary text-white text-sm">
                                <tr>
                                    <th>Fecha de Compra</th>
                                    <th>Número de Orden</th>
                                    <th>Proveedor</th>
                                    <th>T.C</th>
                                    <th>Tipo Moneda</th>
                                    <th>Detalles de Insumos</th>
                                    <th>Estado</th>
                                    <th class="no-export">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="text-sm">

                                @foreach ($compras as $compra)
                                    <tr>
                                        <td>{{ $compra->fecha_compra }}</td>
                                        <td>{{ $compra->numero_orden }}</td>
                                        <td>{{ $compra->proveedor->nombre }}</td>
                                        <td>{{ $compra->tipo_compra }}</td>
                                        <td>{{ $compra->tipo_moneda }}</td>
                                        <td>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Insumo</th>
                                                        <th>Cantidad</th>
                                                        <th>Unidad de Medida</th>
                                                        <th>Precio Unitario</th>
                                                        <th>Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($compra->insumos as $insumo)
                                                        <tr>
                                                            <td>{{ $insumo->nombre }}</td>
                                                            <td>{{ $insumo->pivot->cantidad }}</td>
                                                            <td>{{ $insumo->unidad_medida }}</td>
                                                            <td>$ {{ $insumo->pivot->precio_unitario }}</td>
                                                            <td>$ {{ $insumo->pivot->importe }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            @php
                                                $estadoClass = '';

                                                switch ($compra->estado) {
                                                    case 'En proceso':
                                                        $estadoClass = 'badge badge-primary';
                                                        break;
                                                    case 'Recibido':
                                                        $estadoClass = 'badge badge-success';
                                                        break;
                                                    case 'Devuelto':
                                                        $estadoClass = 'badge badge-warning';
                                                        break;
                                                    case 'Cancelado':
                                                        $estadoClass = 'badge badge-danger';
                                                        break;
                                                }
                                            @endphp

                                            <span class="{{ $estadoClass }}">{{ $compra->estado }}</span>
                                            @if ($compra->estado == 'En proceso')
                                                <div class="mt-2">
                                                    <!-- Agregamos espacio vertical utilizando la clase "mt-2" de Bootstrap -->
                                                    <form action="{{ route('admin.compras.update', $compra->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="estado" value="Recibido">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success">Recibido</button>
                                                    </form>
                                                </div>
                                                <div class="mt-2">
                                                    <!-- Agregamos espacio vertical utilizando la clase "mt-2" de Bootstrap -->
                                                    <form action="{{ route('admin.compras.update', $compra->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="estado" value="Devuelto">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-warning">Devuelto</button>
                                                    </form>
                                                </div>
                                                <div class="mt-2">
                                                    <!-- Agregamos espacio vertical utilizando la clase "mt-2" de Bootstrap -->
                                                    <form action="{{ route('admin.compras.update', $compra->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="estado" value="Cancelado">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger">Cancelado</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="no-export editar-eliminar" data-compra-id="{{ $compra->id }}">
                                            @if ($compra->estado == 'Cancelado')
                                                <form action="{{ route('admin.compras.destroy', $compra->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Estás seguro de eliminar esta compra?')">
                                                        <i class="fa-solid fa-trash fa-fade"></i>
                                                    </button>
                                                </form>
                                            @elseif ($compra->estado == 'Recibido')
                                                <!-- Estado Recibido, ocultar ambos botones -->
                                            @elseif ($compra->estado == 'Devuelto')
                                                {{-- <a href="{{ route('admin.compras.edit', $compra->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fa-solid fa-pen-to-square fa-fade"></i>
                                                </a> --}}
                                            @else
                                                {{-- <a href="{{ route('admin.compras.edit', $compra->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fa-solid fa-pen-to-square fa-fade"></i>
                                                </a> --}}
                                                <form action="{{ route('admin.compras.destroy', $compra->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Estás seguro de eliminar esta compra?')">
                                                        <i class="fa-solid fa-trash fa-fade"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.compras.orden_de_compra', $compra->id) }}"
                                                class="btn btn-primary"><i class="fa-regular fa-file-pdf fa-beat"></i></a>
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
            $('#Compras').DataTable({
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
                        title: 'REPORTE DE COMPRAS DE INSUMOS',
                        extend: 'excel',
                        text: '<i class="fa-regular fa-file-excel fa-beat"></i> Excel',
                        extension: '.xlsx',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                    {
                        title: 'REPORTE DE COMPRAS DE INSUMOS',
                        extend: 'pdfHtml5',
                        text: '<i class="fa-regular fa-file-pdf fa-beat"></i> PDF',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                    {
                        title: 'REPORTE DE COMPRAS DE INSUMOS',
                        extend: 'print',
                        text: '<i class="fa-solid fa-print fa-beat"></i> Imprimir',
                        className: 'btn btn-dark',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                    {
                        title: 'REPORTE DE COMPRAS DE INSUMOS',
                        extend: 'copy',
                        text: '<i class="fa-solid fa-copy fa-beat"></i> Copiar todo',
                        className: 'btn btn-light',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                    },
                ],
            });

            $('.estado-btn').click(function() {
                const estadoActual = $(this).data('estado-actual');
                const nuevoEstado = $(this).val();

                // Ocultar todos los botones de estado
                $('.estado-btn[data-estado-actual="' + estadoActual + '"]').hide();

                // Mostrar solo el estado actualizado
                $('.estado-span[data-estado-actual="' + estadoActual + '"]').removeClass('badge-primary')
                    .addClass('badge-success').text(nuevoEstado);

                // Ocultar los botones de editar y eliminar
                $('.editar-eliminar[data-estado-actual="' + estadoActual + '"]').hide();
            });
        });
    </script>
@endsection
