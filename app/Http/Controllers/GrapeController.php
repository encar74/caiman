<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Session;
use App\Models\Uvas;
use App\Models\Productos;

class GrapeController extends Controller
{
 
    public function __construct()
    {
        session()->put('section', 'grapes');
        
        //quitamos la subsection, porque esta sección no tiene
        session()->forget('subsection');
       
        
    }


    public function index(Request $request) {

        session()->put('section', 'grapes');
        
        //quitamos la subsection, porque esta sección no tiene
        session()->forget('subsection');

        //dd(session()->get('section'));
        //obtenemos los datos del uvas
        /*[TO-DO] crear los modelos para obenter toda la información sobre los tipos de pedidos*/
        $uvas = Productos::active()->where('tipo_producto', '3')->get();


        return view('grapes.list',compact('uvas'));
    }

    public function show($uvas)
    {
       
        $ident_uvas = Crypt::decrypt($uvas);
        
        if ($ident_uvas == 0) {
            // Si el identificador es 0, creamos una nueva instancia de Clientes sin datos.
            $uvas = new Uvas();

        } else {
            // Buscamos los datos del cliente en la base de datos.
            $uvas = Productos::find($ident_uvas);

            // Verificamos si se encontró el cliente en la base de datos.
            if ($uvas) {
                // Si el cliente existe, lo pasamos a la vista.     
                return view('grapes.detail', compact('uvas', 'ident_uvas'));
            } else {
                // Si no se encuentra el cliente, puedes redirigir a otra página con un mensaje de error.
                dd("Cliente no encontrado");
            }
        }
        return view('grapes.detail', compact('uvas', 'ident_uvas'));
    }

    public function deleteUvas($id)
    {
        // Encuentra el cliente por su ID
        $uvas = Productos::find($id);
        
        if ($uvas) {
            // Cambia el valor del campo "activo" a 0
            $uvas->activo = 0;
            $uvas->save();
        } else {
            // Maneja el caso en que el cliente no se encuentre
            // Puedes redirigir o mostrar un mensaje de error
        }
        
        // Redirige de vuelta a la página de clientes
        return redirect('/grapes');
    }



    public function addUvas(Request $request)
    {
        // Obtener el identificador de la URL
        $ident_ = $request->segment(3); // El número depende del índice del segmento en tu URL
    
        // Buscar el cliente por su ID 
        $uvas = Uvas::find($ident_);
    
        // Obtener el ID del cliente
        if ($uvas != null) {
            $uvas_id = $uvas->id;
        } else {
            $uvas_id = 0;
        }
    
        if ($uvas_id != 0) {
            $uvas->update([
                'referencia' => $request->input('referencia'),
                'nombre' => $request->input('nombre'),
                'precio' => $request->input('precio'),
                'notas' => $request->input('desc') // Notas es opcional, pero se pasa si se proporciona en la solicitud
            ]);
    
            return redirect('/grapes');
        } else {
            // Si el cliente no existe, crear uno nuevo
            $uvas = new Uvas([
                'referencia' => $request->input('referencia'),
                'nombre' => $request->input('nombre'),
                'precio' => $request->input('precio'),
                'notas' => $request->input('desc') // Notas es opcional, pero se pasa si se proporciona en la solicitud
            ]);
    
            // Guardar el nuevo cliente en la base de datos
            $uvas->save();
    
            return redirect('/grapes');
        }
    }
    

}


