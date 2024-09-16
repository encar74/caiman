<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    <title>ALBARÁN</title>

    <!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    <title>ALBARÁN</title>

    <style>
        /* Estilos adicionales */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            margin-top: 5%;
            width: 80%;
            margin-left: 10%;
            margin-right: 10%;
        }

        header {
            margin-bottom: 10px;
        }

        .title {

            color: black;
            padding: 3px;
            border: 1px solid white;
            border-bottom: 0;
            text-align: right;
            margin-bottom: 10px;
            position: relative;
        }

        .title h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;

        }

        .client-info {
            margin-bottom: 20px;
            text-align: left; /* Alinear los datos a la izquierda */
            position: relative; /* Ajustar la posición relativa */
        }

        .client-info p {
            margin: 0; /* Ajuste de margen */
            padding: 5px 0; /* Ajuste de relleno */
            font-weight: bold;
            vertical-align: bottom; /* Alinear verticalmente en la parte inferior */
            position: absolute; /* Ajustar la posición absoluta */
            bottom: 0; /* Alinear el texto a la parte inferior */
            left: 0; /* Alinear el texto a la izquierda */
        }

        .recipient-details {
            margin-bottom: 20px;
        }

        .recipient-details table {
            border-collapse: collapse;
            width: 100%;
        }

        .recipient-details th,
        .recipient-details td {
            border: 1px solid white;
            padding: 8px;
            font-size: 14px;
            text-align: center;
            background-color: #f2f2f2;
        }

        .recipient-details th {
            background-color: #1B84FF;
            color: white;
            font-weight: bold;
        }

        .recipient-details tr:first-child th {
            background-color: #1B84FF;
            color: white;
            font-weight: bold;
        }

        .notas {
            margin-bottom: 20px;
        }

        .notas h5 {
            margin-bottom: 5px;
            padding-bottom: 0;
        }

        .total-container {
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: right;
        }

        .total-container p {
            margin: 15px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="page-break"></div>
    <header>
    <table width="100%">
    <tr>
        <!-- Celda Izquierda: Logo y Emisor -->
        <td width="50%">
            <table width="100%">
                <tr>
                    <td>
                        <img src="img/Logo_Frutas_ElCaiman.jpg" alt="Logo" style="width: 150px;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Documento emitido por:<br>
                        Frutas El Caimán, S.L.<br>
                        Frutas El Caimán<br>
                        B42624320<br>
                        AVENIDA JAIME I, 13<br>
                        03670 Monforte del Cid<br>
                        Alicante<br>
                        España<br>
                        noeliafrutascaiman@gmail.com</p>
                    </td>
                </tr>
            </table>
        </td>

      <!-- Celda Derecha: Título "ALBARÁN" y Datos del Cliente -->
<td width="50%" style="text-align: left; vertical-align: bottom;">
    <div class="title">
        <h1 style="margin-bottom: 10px;">ALBARÁN</h1>
        <h1 style="margin-bottom: 50%;">{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
    </div>
    <div class="client-info">
        <table>
            <tr>
                <td style="padding-right: 30px; font-weight: bold;">Cliente:</td>
                <td>{{ $cliente->nombre_comercial }}</td>
            </tr>
            <tr>
                <td style="padding-right: 30px; font-weight: bold;">Dirección:</td>
                <td>{{ $direccion->identificador_direccion }}</td>
            </tr>
            <tr>
                <td style="padding-right: 30px; font-weight: bold;">Fecha de Pedido:</td>
                <td>{{ $order->fecha }}</td>
            </tr>
            <tr>
                <td style="padding-right: 30px; font-weight: bold;">Fecha de Entrega:</td>
                <td>{{ $order->fecha_entrega }}</td>
            </tr>
            <tr>
                <td style="padding-right: 30px; font-weight: bold;">Transporte:</td>
                <td>{{ $order->transporte }}</td>
            </tr>
        </table>


    </div>
</td>

    </tr>
</table>


    </header>

<!-- Líneas de Pedido -->
<div class="recipient-details">
    <table cellspacing="0">
        <thead>
            <tr>
                @php
                    $headers = [
                        'Articulo', 'Lote', 'Trazabilidad',
                        'Referencia', 'Kg_Caja', 'Cantidad', 'Comision', 'Precio'
                    ];

                    $emptyColumns = [];

                    // Check for empty columns
                    foreach ($headers as $key => $header) {
                        $columnData = array_column($lineasPedido->toArray(), strtolower(str_replace(' ', '_', $header)));
                        if (array_sum(array_map('strlen', $columnData)) === 0) {
                            $emptyColumns[] = $key;
                        }
                    }
                @endphp

                @foreach ($headers as $key => $header)
                    @if (!in_array($key, $emptyColumns))
                        <th>{{ $header }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $totalPreciosProductos = 0;
            @endphp
            @foreach($lineasPedido as $linea)
                <tr>
                    @foreach ($headers as $key => $header)
                        @if (!in_array($key, $emptyColumns))
                            <td>
                                @if ($header === 'Articulo')
                                    {{ $linea->articulo->nombre_articulo }}
                                @elseif ($header === 'Lote')
                                    {{ $linea->lote }} <!-- Aquí se muestra el lote -->
                                @elseif ($header === 'Precio')
                                    {{ $linea->{strtolower(str_replace(' ', '_', $header))} }}€
                                @else
                                    {{ $linea->{strtolower(str_replace(' ', '_', $header))} }}
                                @endif
                            </td>
                            @if ($header === 'Precio')
                                @php
                                    $totalPreciosProductos += $linea->{strtolower(str_replace(' ', '_', $header))};
                                @endphp
                            @endif
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Notas -->
<div class="notas">
    <h5>Notas</h5>
    <p>{{ $order->notas }}</p>
</div>

<div class="total-container">
@php
    // Calcular el importe total aplicando el porcentaje de IVA
    $ivaTotal = 0;
    foreach ($lineasPedido as $linea) {
        $ivaTotal += $linea->precio * ($linea->articulo->iva / 100);
    }
    $importeTotalSinIVA = number_format($totalPreciosProductos, 2); // Formatear el total sin IVA con dos decimales
@endphp
<p>Total sin IVA: &nbsp;&nbsp;&nbsp;&nbsp; {{ $importeTotalSinIVA }} €</p>
<p>IMPORTE TOTAL: &nbsp; {{ $order->importe_total }} €</p>
</div>



</body>

</body>
</html>