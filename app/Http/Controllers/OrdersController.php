<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Session;
use App\Models\Direcciones;
use App\Models\Productos;
use App\Models\Pedidos;
use App\Models\Option;
use App\Models\Linea_pedidos;
use Ramsey\Uuid\Uuid;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{

    public function __construct()
    {
        session()->put('section', 'order');
        
    }


     /**
     * Display a listing of orders
     * @param object Request the request object
     * @return blade view | ajax view
     */
    
     public function index($tipo)
     {
         session()->put('section', 'order');

         $tipoPedido = new Collection();
         switch($tipo){
             case 'mermeladas-conservas': 
                 $ident_tipo = 1; 
                 $tipoPedido->nombre  = "Mermeladas y Conservas"; 
                 break;
             case 'campanas': 
                 $ident_tipo = 2; 
                 $tipoPedido->nombre  = "Campaña"; 
                 break;
             case 'noche-vieja': 
                 $ident_tipo = 3; 
                 $tipoPedido->nombre  = "Noche Vieja"; 
                 break;
            case 'todos':
                $ident_tipo = 4; 
                $tipoPedido->nombre  = "Todos los Pedidos"; 
                break;
             default: 
                 // Redirigir en caso de un tipo desconocido
                 return redirect('/');
         }
     
         $tipoPedido->id = $ident_tipo;
     
         session()->put('subsection', $ident_tipo);
     
         $ident_ = request()->segment(2);
         // Obtener los pedidos según el tipo
        if ($ident_tipo == 4) {
            // Si el tipo es "todos", obtener todos los pedidos
            $pedidos = Pedidos::where('activo', '!=', 0)->get();

        } else {
            // Si es un tipo específico, obtener los pedidos correspondientes
            $pedidos = Pedidos::where('tipo', $ident_tipo)->where('activo', '!=', 0)->get();

        }

     

         return view('orders.list', compact('tipoPedido', 'pedidos'));
     }
    
     /**
     * Display a detail of Order
     * @param  ident
     * @return blade view | ajax view
     */
// En el controlador OrdersController.php

public function show(Request $request, $orders) {

    // Obtener todos los clientes
    $clientes = ["" => 'Selecciona un cliente'] + Clientes::active()->get()->pluck('nombre_comercial', 'id')->toArray();

    $productos = Productos::active()->get()->toArray();
    

    // Obtener todas las direcciones
    $direcciones = Direcciones::where('activo', 1)->get();

    $ident_order = Crypt::decrypt($orders);

    if($ident_order!=0){
    // Busca el pedido en la base de datos usando el ID desencriptado
    $pedido = Pedidos::findOrFail($ident_order);
 
    // Obtiene el valor del campo "tipo" del pedido
    $tipo_pedido = $pedido->tipo;
    
    // Obtener el pedido
    
    $order = new Collection();
    $order->id_type = $ident_order;
    $order->type = new Collection();
    $order->type->nombre = "Mermeladas y Conserva";
    $order->client = new Collection();
    $order->client->name = "Quiero Delicatessen";
    $order->date = '2023-09-25';
    $order->date_delivery = '2023-10-25';
    $order->notes = " ";

    $template_order = "order-mermelada";
    $order->type->ruta = "mermeladas-conservas";
    if ($tipo_pedido == 2) {
        $template_order = "order-campana";
        $order->type->nombre = "Campaña";
        $order->type->ruta = "campana";
    } elseif ($tipo_pedido == 3) {
        $template_order = "order-noche-vieja";
        $order->type->nombre = "Noche Vieja";
        $order->type->ruta = "noche-vieja";
    }
}

    if ($ident_order == 0) {
        // Si el identificador es 0, creamos una nueva instancia de Clientes sin datos.
        $orders = new Pedidos();

        $order = new Collection();
        $order->id_type = $ident_order;
        $order->type = new Collection();
        $order->type->nombre = "Mermeladas y Conserva";
        $order->client = new Collection();
        $order->client->name = "Quiero Delicatessen";
        $order->date = '2023-09-25';
        $order->date_delivery = '2023-10-25';
        $order->notes = " ";
        
        // Obtener la URL de la página anterior
    $urlAnterior = url()->previous();

    // Parsear la URL y obtener los segmentos
    $segmentos = parse_url($urlAnterior, PHP_URL_PATH);
    $segmentos = explode('/', trim($segmentos, '/'));

    // Obtener el tercer segmento, si existe
    $segundoSegmentoAnterior = $segmentos[1] ?? null;

    if($segundoSegmentoAnterior=="mermeladas-conservas"){
        $template_order = "order-mermelada";
        $order->type->nombre = "Mermeladas y Conserva";
        $order->type->ruta = "mermeladas-conservas";
    }
    if($segundoSegmentoAnterior=="campanas"){
        $template_order = "order-campana";
        $order->type->nombre = "Campaña";
        $order->type->ruta = "campana";
    }
    if($segundoSegmentoAnterior=="noche-vieja"){
        $template_order = "order-noche-vieja";
        $order->type->nombre = "Noche Vieja";
        $order->type->ruta = "noche-vieja";
    }
    
    } else {
        // Buscamos los datos del cliente en la base de datos.
        $orders = Pedidos::find($ident_order);

        // Verificamos si se encontró el cliente en la base de datos.
        if ($orders) {
            // Si el cliente existe, lo pasamos a la vista.
            // return view('customers.detail', compact('cliente'));
            $lineasPedido = $orders->linea_pedidos()->where('activo', 1)->get();

            return view('orders.'.$template_order, compact('order', 'clientes', 'direcciones', 'productos', 'ident_order', 'lineasPedido', 'orders'));
        } else {
            // Si no se encuentra el cliente, puedes redirigir a otra página con un mensaje de error.
            dd("Cliente no encontrado");
        }
    }

    // Guardar la sección en la que estamos
    session()->put('subsection', $orders->id_type);

    // Llamar a la vista, pasando los datos necesarios
    return view('orders.'.$template_order, compact('order', 'clientes', 'direcciones', 'productos', 'ident_order'));
}



public function getDirecciones(Request $request) {

    $clienteId = $request->input('clienteId');
    $direcciones = Direcciones::where('clientes_id', $clienteId)->pluck('direccion', 'id')->toArray();

    return response()->json($direcciones);
}

public function getDatosArticulo(Request $request) {
    $articuloId = $request->input('articuloId');
    $producto = Productos::find($articuloId);

    return response()->json($producto);
}

public function addPedido(Request $request)
{
    // Obtener el identificador de la URL
    $ident_ = $request->segment(3);

    // Buscar el cliente por su ID 
    $pedido = Pedidos::find($ident_);

    // Obtener el ID del cliente
    if ($pedido != null) {
        $pedido_id = $pedido->id;
    } else {
        $pedido_id = 0;
    }

    $cliente_id = $request->input('cliente');

    // Buscar el cliente en la base de datos
    $cliente = Clientes::find($cliente_id);

    $destino_id = $request->input('destino');

    // Buscar la dirección en la base de datos
    $destino = Direcciones::find($destino_id);

// Verificar si es un pedido existente o nuevo
if ($pedido_id == 0) {
    // Crear un nuevo pedido
    $pedido = new Pedidos();
} else {
    // Obtener el pedido existente de la base de datos
    $pedido = Pedidos::findOrFail($pedido_id);
}

// Asignar los valores al pedido
$pedido->id_cliente = $request->input('cliente');
$pedido->id_direccion = $request->input('destino');
$pedido->fecha = $request->input('fecha_pedido');
$pedido->fecha_entrega = $request->input('fecha_entrega');
$pedido->transporte = $request->input('entrega');
$pedido->tipo = $request->input('tipo');
$pedido->importe_total = $request->input('total_pedido_hidden');
$pedido->estado = $request->input('estado');
$pedido->notas = $request->input('notas');

// Guardar el pedido en la base de datos
$pedido->save();

// Obtener el ID del pedido recién creado o actualizado
$pedido_id = $pedido->id;


    // Obtener las líneas de pedido del formulario
    $lineasPedido = $request->input('lineas_pedido');

    foreach ($lineasPedido as $index => $lineaData) {
        // Verificar si 'id' existe en $lineaData y no es una cadena vacía
        if (array_key_exists('id', $lineaData) && $lineaData['id'] !== '') {
            // Verificar si la línea de pedido ya existe
            $lineaExistente = Linea_pedidos::find($lineaData['id']);

            if ($lineaExistente !== null) {
                // Actualizar la línea de pedido existente

                $lineaExistente->update([
                    'articulo_id' => $lineaData['producto_id'],
                    'articulo' => $lineaData['articulo'],
                    'cantidad' => $lineaData['cantidad'],
                    'precio' => $lineaData['precio'],
                    'comision' => isset($lineaData['comision']) ? $lineaData['comision'] : null,
                    'referencia' => isset($lineaData['referencia']) ? $lineaData['referencia'] : null,
                    'trazabilidad' => isset($lineaData['trazabilidad']) ? $lineaData['trazabilidad'] : null,
                    'kg_caja' => isset($lineaData['kg_caja']) ? $lineaData['kg_caja'] : null,
                    'lote' => isset($lineaData['lote']) ? $lineaData['lote'] : null,
                    // Actualizar otros campos de la línea de pedido si es necesario
                ]);
    
            }
        } else {

            // Crear una nueva línea de pedido con el UUID temporal como ID
            $linea = new Linea_pedidos([
                'articulo_id' => $lineaData['producto_id'],
                'articulo' => $lineaData['articulo'],
                'cantidad' => $lineaData['cantidad'],
                'precio' => $lineaData['precio'],
                'comision' => isset($lineaData['comision']) ? $lineaData['comision'] : null,
                'referencia' => isset($lineaData['referencia']) ? $lineaData['referencia'] : null,
                'trazabilidad' => isset($lineaData['trazabilidad']) ? $lineaData['trazabilidad'] : null,
                'kg_caja' => isset($lineaData['kg_caja']) ? $lineaData['kg_caja'] : null,
                'lote' => isset($lineaData['lote']) ? $lineaData['lote'] : null,
                // Asignar otros campos de la línea de pedido si es necesario
            ]);
            
            // Guardar la línea de pedido en la base de datos
            $linea->save();

            // Asociar la línea de pedido al pedido actual
            $pedido->linea_pedidos()->save($linea);

            // Actualizar el stock del producto correspondiente
                $producto = Productos::find($linea->articulo_id);
                if ($producto) {
                    $producto->stock -= $linea->cantidad;
                    $producto->save();
                }

        }
    }
        /** */
    

    if($request->estado=='Confirmado' && $pedido->ya_en_factura_directa==0){

        //1º tenemos que mirar si el conacato ya existe en holded, si no existe lo creamos
        //dd($pedido->cliente);
    }


    Session::flash('alert-success', 'El pedido se ha guardado correctamente');
    $url = "orders/".$pedido->tipo;

    // Redireccionar al formulario principal de pedidos
    return redirect('/');

    }




    public function deleteLinea($id)
    {
        // Encuentra la línea de pedido por su ID
        $lineaPedido = Linea_pedidos::find($id);
    
        if ($lineaPedido) {
            // Recupera el producto correspondiente
            $producto = Productos::find($lineaPedido->articulo_id);
    
            if ($producto) {
                // Sumar la cantidad eliminada al stock
                $producto->stock += $lineaPedido->cantidad;
                $producto->save();
            }
    
            // Cambia el valor del campo "activo" a 0 en lugar de eliminar la fila
            $lineaPedido->activo = 0;
            $lineaPedido->save();
    
            // Devuelve una respuesta JSON indicando que la operación fue exitosa
            return response()->json(['success' => true]);
        }
    }
    

public function deleteOrder($id)
{
    // Encuentra el pedido por su ID
    $pedido = Pedidos::find($id);

    if ($pedido) {
        // Obtener todas las líneas de pedido asociadas
        $lineasPedido = $pedido->linea_pedidos()->where('activo', 1)->get();

        // Restaurar el stock de cada producto en las líneas de pedido
        foreach ($lineasPedido as $linea) {
            $producto = Productos::find($linea->articulo_id);

            if ($producto) {
                // Sumar la cantidad de la línea de pedido al stock del producto
                $producto->stock += $linea->cantidad;
                $producto->save();
            }
        }

        // Cambia el valor del campo "activo" a 0 en lugar de eliminar la fila
        $pedido->activo = 0;
        $pedido->save();
    
    // Redirige de vuelta a la página de clientes
    return redirect('/');
    }
}

public function generarPdf($ident)
{
    // Obtener los datos necesarios para la vista
    $order = Pedidos::find($ident);

    // Verificar si el pedido existe
    if (!$order) {
        return redirect()->back()->with('error', 'Pedido no encontrado.');
    }

    // Obtener las líneas de pedido activas asociadas al pedido actual
    $lineasPedido = Linea_pedidos::where('pedidos_id', $order->id)
        ->where('activo', 1)
        ->get();

    // Obtener el cliente y la dirección utilizando los IDs almacenados en el pedido
    $cliente = Clientes::find($order->id_cliente);
    $direccion = Direcciones::find($order->id_direccion);

    // Obtener los artículos asociados a cada línea de pedido
    foreach ($lineasPedido as $linea) {
        // Obtener el artículo utilizando el ID almacenado en la línea de pedido
        $articulo = Productos::find($linea->articulo_id);
        // Agregar el artículo a la línea de pedido
        $linea->articulo = $articulo;
        // Obtener el valor del IVA del artículo y agregarlo a la línea de pedido
        $linea->iva = $articulo->iva;
    }

    // Pasar los datos a la vista del PDF
    $pdf = PDF::loadView('orders.pdf', compact('order', 'lineasPedido', 'cliente', 'direccion'));
    return $pdf->stream('technical-monitoring-'.$order->type_slug.'-'.time().'.pdf');
}




public function enviarMail($ident)
{
    // Obtener los datos necesarios para la vista
    $order = Pedidos::find($ident);

    // Verificar si el pedido existe
    if (!$order) {
        return redirect()->back()->with('error', 'Pedido no encontrado.');
    }

    // Obtener las líneas de pedido activas asociadas al pedido actual
    $lineasPedido = Linea_pedidos::where('pedidos_id', $order->id)
        ->where('activo', 1)
        ->get();

    // Obtener el cliente y la dirección utilizando los IDs almacenados en el pedido
    $cliente = Clientes::find($order->id_cliente);
    $direccion = Direcciones::find($order->id_direccion);

    // Obtener los artículos asociados a cada línea de pedido
    foreach ($lineasPedido as $linea) {
        // Obtener el artículo utilizando el ID almacenado en la línea de pedido
        $articulo = Productos::find($linea->articulo_id);
        // Agregar el artículo a la línea de pedido
        $linea->articulo = $articulo;
        // Obtener el valor del IVA del artículo y agregarlo a la línea de pedido
        $linea->iva = $articulo->iva;
    }

    // Generar el PDF
    $pdf = PDF::loadView('orders.proforma', compact('order', 'lineasPedido', 'cliente', 'direccion'));

    // Guardar el PDF temporalmente en el directorio de almacenamiento de Laravel
    $tempFileName = 'technical-monitoring-' . $order->type_slug . '-' . time() . '.pdf';
    $tempFilePath = 'temp/' . $tempFileName;
    Storage::put($tempFilePath, $pdf->output());

    // Enviar correo electrónico
    Mail::send('orders.mail', compact('order', 'lineasPedido', 'cliente', 'direccion'), function ($message) use ($tempFilePath, $cliente) {
        $message->to($cliente->email)->subject('Asunto del Correo');
        $message->attach(storage_path('app/' . $tempFilePath), ['as' => 'Factura Proforma ElCaiman.pdf']);
    });

    // Eliminar el PDF temporal
    Storage::delete($tempFilePath);

    return redirect()->back()->with('success', 'Correo electrónico enviado con éxito.');
}


}
    
