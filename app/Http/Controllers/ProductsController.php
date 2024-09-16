<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Session;
use App\Models\Productos;


class ProductsController extends Controller
{
 
    public function __construct()
    {
        session()->put('section', 'product');
        
        //quitamos la subsection, porque esta sección no tiene
        session()->forget('subsection');
       
        
    }


    public function index(Request $request) {

        session()->put('section', 'product');
        
        //quitamos la subsection, porque esta sección no tiene
        session()->forget('subsection');

        //dd(session()->get('section'));
        //obtenemos los datos del producto
        /*[TO-DO] crear los modelos para obenter toda la información sobre los tipos de pedidos*/

        $productos = Productos::active()->whereNotIn('tipo_producto', ['3'])->get();

        return view('products.list',compact('productos'));
    }

    public function show($producto)
    {
       
        $ident_producto = Crypt::decrypt($producto);
        
        if ($ident_producto == 0) {
            // Si el identificador es 0, creamos una nueva instancia de Clientes sin datos.
            $producto = new Productos();
         
        } else {
            // Buscamos los datos del cliente en la base de datos.
            $producto = Productos::find($ident_producto);
    
            // Verificamos si se encontró el cliente en la base de datos.
            if ($producto) {
                // Si el cliente existe, lo pasamos a la vista.     
                return view('products.detail', compact('producto', 'ident_producto'));
            } else {
                // Si no se encuentra el cliente, puedes redirigir a otra página con un mensaje de error.
                dd("Cliente no encontrado");
            }
        }
        return view('products.detail', compact('producto', 'ident_producto'));
    }

    public function deleteProduct($id)
    {
        // Encuentra el cliente por su ID
        $roducto = Productos::find($id);
        
        if ($roducto) {
            // Cambia el valor del campo "activo" a 0
            $roducto->activo = 0;
            $roducto->save();
        } else {
            // Maneja el caso en que el cliente no se encuentre
            // Puedes redirigir o mostrar un mensaje de error
        }
        
        // Redirige de vuelta a la página de clientes
        return redirect('/products');
    }



public function addProducto(Request $request)
{

    // Obtener el identificador de la URL
    $ident_ = $request->segment(3); // El número depende del índice del segmento en tu URL

    // Buscar el cliente por su ID 
    $producto = Productos::find($ident_);

    // Obtener el ID del cliente
    if ($producto != null) {
    $producto_id = $producto->id;
    }else{
    $producto_id=0;
    }

    if ($producto_id!=0) {

        $producto->update([
            'tipo_producto' => $request->input('tipo_producto'),
            'referencia' => $request->input('referencia'),
            'nombre_articulo' => $request->input('nombre_articulo'),
            'trazabilidad' => $request->input('trazabilidad'),
            'kg_caja' => $request->input('kg_caja'),
            'precio' => $request->input('precio'),
            'iva' => $request->input('iva'),
            'stock' => $request->input('stock'),
            'lote' => $request->input('lote'),
            'notas' => $request->input('desc')
        ]);


    } else {
        // Si el cliente no existe, crear uno nuevo
        $producto = new Productos([
            'tipo_producto' => $request->input('tipo_producto'),
            'referencia' => $request->input('referencia'),
            'nombre_articulo' => $request->input('nombre_articulo'),
            'trazabilidad' => $request->input('trazabilidad'),
            'kg_caja' => $request->input('kg_caja'),
            'precio' => $request->input('precio'),
            'iva' => $request->input('iva'),
            'stock' => $request->input('stock'),
            'lote' => $request->input('lote'),
            'notas' => $request->input('desc')
        ]);

        // Guardar el nuevo cliente en la base de datos
        $producto->save();

    }

            // Obtener el tipo de producto del formulario
            $tipo_producto = $request->input('tipo_producto');

            if ($tipo_producto === '2' || $tipo_producto === '1') {
                return redirect('/products');
            } elseif ($tipo_producto === '3') {
                return redirect('/grapes');
            }
}

}


