<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    <title>Factura Proforma</title>

    <style>
        html{
            margin: 10px 15px;
            padding: 0;
        }
        body {
            padding:0;
            width: 100%;
            font-size: 13px;
            font-family: arial;
        }
    </style>
</head>
<body>
Documento emitido por: <br>
Frutas El Caimán, S.L. <br>
Frutas El Caimán <br>
B42624320 <br>
AVENIDA JAIME I, 13 <br>
03670 Monforte del Cid <br>
Alicante <br>
España <br>
noeliafrutascaiman@gmail.com <br><br><br><br>

<strong>Cliente: </strong> {{$cliente->nombre_comercial}} <br>
<strong>Dirección: </strong> {{$direccion->identificador_direccion}} <br>
<strong>Fecha de Pedido: </strong> {{$order->fecha}} <br>



    <small>Este email se ha generado de forma automática, por favor, no responda a este email.<br>
    La información contenida en este correo electrónico y en todos sus archivos anexos es confidencial y privilegiada, si por algún motivo recibe esta comunicación y usted no es el destinatario autorizado bórrelo de inmediato, notifíquele su error a la persona que se lo envió y abstengase de divulgar su contenido y anexos, ya que esta información solo puede ser utilizada por la persona a quien está dirigida. Está prohibido cualquier uso inadecuado de esta información, así como la generación de copias de este mensaje.</small>
</body>
</html>