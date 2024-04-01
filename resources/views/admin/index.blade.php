@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Panel Administrativo</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-md-4">
            {{-- Usuarios --}}
            <x-adminlte-small-box title="{{ $insumosSum }}" text="Insumos" icon="fa fa-archive" theme="danger"
                url="{{ route('admin.insumos.index') }}" url-text="Ver Insumos">
            </x-adminlte-small-box>
        </div>
        <div class="col-md-4">
            {{-- Presentaciones de Horchatas --}}
            <x-adminlte-small-box title="{{ $horchatasSum }}" text="Presentaciones de Horchatas" icon="fa fa-beer"
                theme="warning" url="{{ route('admin.horchatas.index') }}" url-text="Ver presentaciones de Horchatas">
            </x-adminlte-small-box>
        </div>
        <div class="col-md-4">
            {{-- Proveedores --}}
            <x-adminlte-small-box title="{{ $proveedoresSum }}" text="Proveedores" icon="fas fa-truck" theme="warning"
                url="{{ route('admin.proveedores.index') }}" url-text="Ver Proveedores">
            </x-adminlte-small-box>
        </div>
        <div class="col-md-4">
            {{-- Pedidos --}}
            <x-adminlte-small-box title="{{ $comprasSum }}" text="Compras de Insumo" icon="fas fa-shopping-cart"
                theme="success" url="{{ route('admin.compras.index') }}" url-text="Ver Compras de Insumo">
            </x-adminlte-small-box>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="p-3">
                        <canvas id="graficoPedidosHoy" width="200" height="200"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3">
                        <canvas id="graficoPedidosMes" width="200" height="200"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3">
                        <canvas id="graficoPedidosAno" width="200" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@stop

@section('css')
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script>
        var dataHoy = @json($pedidosHoyData);
        var labelsHoy = dataHoy.map(function(item) {
            return item.presentacion;
        });
        var valuesHoy = dataHoy.map(function(item) {
            return item.cantidad;
        });

        var dataMes = @json($pedidosMesData);
        var labelsMes = dataMes.map(function(item) {
            return item.presentacion;
        });
        var valuesMes = dataMes.map(function(item) {
            return item.cantidad;
        });

        var dataAno = @json($pedidosAnoData);
        var labelsAno = dataAno.map(function(item) {
            return item.presentacion;
        });
        var valuesAno = dataAno.map(function(item) {
            return item.cantidad;
        });

        var backgroundColorsAno = dataAno.map(function(item, index) {
            // Asigna un color diferente a cada barra
            var colors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'];
            return colors[index];
        });

        // Define una paleta de colores personalizada para cada presentación de horchata
        var customColors = [
            'blue', // Color azul intenso
            'yellow', // Color amarillo intenso
            'orange', // Color naranja intenso
            'purple', // Color morado intenso
            'white', // Color blanco intenso
            // Agrega más colores aquí según sea necesario
        ];

        var options = {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'black' // Color blanco intenso para los números del eje Y
                    }
                },
                x: {
                    ticks: {
                        color: 'black' // Color blanco intenso para los labels (etiquetas) del eje X
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        };

        var chartPedidosHoy = new Chart('graficoPedidosHoy', {
            type: 'bar',
            data: {
                labels: labelsHoy,
                datasets: [{
                    label: 'Pedidos Hoy',
                    data: valuesHoy,
                    backgroundColor: customColors,
                    borderColor: 'rgba(128, 255, 128, 1)',
                    borderWidth: 1
                }]
            },
            options: options
        });

        var chartPedidosMes = new Chart('graficoPedidosMes', {
            type: 'bar',
            data: {
                labels: labelsMes,
                datasets: [{
                    label: 'Pedidos Mes',
                    data: valuesMes,
                    backgroundColor: customColors,
                    borderColor: 'rgba(255, 128, 128, 1)',
                    borderWidth: 1
                }]
            },
            options: options
        });

        var chartPedidosAno = new Chart('graficoPedidosAno', {
            type: 'bar',
            data: {
                labels: labelsAno,
                datasets: [{
                    label: 'Pedidos Año',
                    data: valuesAno,
                    backgroundColor: customColors,
                    borderColor: 'rgba(128, 128, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: options
        });
    </script> --}}

    {{-- <script>
        var dataHoy = @json($pedidosHoyData);
        var labelsHoy = dataHoy.map(function(item) {
            return item.presentacion;
        });
        var valuesHoy = dataHoy.map(function(item) {
            return item.cantidad;
        });
        var backgroundColorsHoy = dataHoy.map(function(item, index) {
            // Asigna un color diferente a cada barra
            var colors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'];
            return colors[index];
        });

        var dataMes = @json($pedidosMesData);
        var labelsMes = dataMes.map(function(item) {
            return item.presentacion;
        });
        var valuesMes = dataMes.map(function(item) {
            return item.cantidad;
        });
        var backgroundColorsMes = dataMes.map(function(item, index) {
            // Asigna un color diferente a cada barra
            var colors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'];
            return colors[index];
        });

        var dataAno = @json($pedidosAnoData);
        var labelsAno = dataAno.map(function(item) {
            return item.presentacion;
        });
        var valuesAno = dataAno.map(function(item) {
            return item.cantidad;
        });
        var backgroundColorsAno = dataAno.map(function(item, index) {
            // Asigna un color diferente a cada barra
            var colors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'];
            return colors[index];
        });

        var options = {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'black' // Color blanco intenso para los números del eje Y
                    }
                },
                x: {
                    ticks: {
                        color: 'black' // Color blanco intenso para los labels (etiquetas) del eje X
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    color: 'black'
                }
            }
        };

        var chartPedidosHoy = new Chart('graficoPedidosHoy', {
            type: 'bar',
            data: {
                labels: labelsHoy,
                datasets: [{
                    label: 'Pedidos Hoy',
                    data: valuesHoy,
                    backgroundColor: backgroundColorsHoy,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: options
        });

        var chartPedidosMes = new Chart('graficoPedidosMes', {
            type: 'bar',
            data: {
                labels: labelsMes,
                datasets: [{
                    label: 'Pedidos Mes',
                    data: valuesMes,
                    backgroundColor: backgroundColorsMes,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: options
        });

        var chartPedidosAno = new Chart('graficoPedidosAno', {
            type: 'bar',
            data: {
                labels: labelsAno,
                datasets: [{
                    label: 'Pedidos Año',
                    data: valuesAno,
                    backgroundColor: backgroundColorsAno,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: options
        });
    </script> --}}
@stop
