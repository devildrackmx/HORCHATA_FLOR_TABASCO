<!DOCTYPE html>
<html>

<head>
    <title>Orden de Compra</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Agrega los enlaces a los archivos CSS y JavaScript de Bootstrap 4 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .table-bordered,
        .table-bordered thead,
        .table-bordered tbody,
        .table-bordered th,
        .table-bordered td {
            border: 3px solid black !important;
        }

        .custom-row {
            display: flex;
            align-items: center;/
        }

        .custom-col {
            flex: 1;
        }

        .info-div {
            margin-bottom: 20px;
        }

        .linea-amarilla {
            height: 5px;
            margin-top: 20px;
        }

        .separados {
            border-collapse: separate;
            border-spacing: 30px;
        }
    </style>
</head>

<body>

    <table style="width: 100%;">
        <tr>
            <td style="width: 33.33%;">
                <img src="image/logo_FlorTabasco.png" alt="" width="80px" height="80px" class="">
            </td>
            <td style="width: 33.33%;">
                <h5>Orden de Compra</h5>
            </td>
            <td colspan="5" class="text-center table table-bordered">
                <p>Fecha: {{ $compra->fecha_compra }}</p>
                <p>N° orden: {{ $compra->numero_orden }}</p>
            </td>
        </tr>
    </table>

    <div class="bg-warning linea-amarilla"></div>

    <table style="width: 100%;" class="table mt-4 info-div text-center separados">
        <tr>
            <td class="border border-dark" style="padding-right: 8px;">
                <div>
                    <strong>Proveedor:</strong> {{ $compra->proveedor->nombre }}
                </div>
                <div>
                    <strong>Calle:</strong> {{ $compra->proveedor->calle }}
                </div>
                <div>
                    <strong>Colonia:</strong> {{ $compra->proveedor->colonia }}
                </div>
                <div>
                    <strong>CP:</strong> {{ $compra->proveedor->codigo_postal }}
                </div>
                <div>
                    <strong>Ciudad:</strong> {{ $compra->proveedor->ciudad }}
                </div>
                <div>
                    <strong>Teléfono:</strong> {{ $compra->proveedor->telefono }}
                </div>
            </td>
            <td class="border border-dark" style="padding-left: 8px;">
                <div>
                    <strong>Comprador:</strong> Cisur S. de R.L.
                </div>
                <div>
                    <strong>Calle:</strong> Carr. Fed. Teapa-Pichucalco
                </div>
                <div>
                    <strong>Colonia:</strong> Chapultepec
                </div>
                <div>
                    <strong>CP:</strong> 86801
                </div>
                <div>
                    <strong>Ciudad:</strong> Teapa, Tabasco
                </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-bordered">
                <thead class="bg-warning">
                    <tr>
                        <th>CANTIDAD</th>
                        <th>UNIDAD</th>
                        <th>CONCEPTO</th>
                        <th>P.U</th>
                        <th>IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compra->insumos as $insumo)
                        <tr>
                            <td>{{ $insumo->pivot->cantidad }}</td>
                            <td>{{ $insumo->unidad_medida }}</td>
                            <td>{{ $insumo->nombre }}</td>
                            <td>$ {{ $insumo->pivot->precio_unitario }}</td>
                            <td>$ {{ $insumo->pivot->importe }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">Subtotal</td>
                        <td>$ {{ $compra->subtotal }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">IVA</td>
                        <td>
                            @if ($compra->iva !== null)
                                {{ $compra->iva }} %
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <h6>Total {{ $compra->tipo_moneda }}</h6>
                        </td>
                        <td>
                            <h6>$ {{ $compra->total }}</h6>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xs-12">
            <p class="">Elabora:</p>
            <p class="font-weight-bold">M.A.E Mónica Farias Pinto</p>
            <p>Director General</p>
        </div>
    </div>
    <!-- Agrega los enlaces a los archivos JavaScript de Bootstrap 4 (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
