<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Session;
use App\Models\FormasEntrega;


class DeliveryController extends Controller
{
 
    public function __construct()
    {
        session()->put('section', 'delivery');
        
        //quitamos la subsection, porque esta sección no tiene
        session()->forget('subsection');
       
        
    }


    public function index(Request $request) {

        session()->put('section', 'delivery');
        
        //quitamos la subsection, porque esta sección no tiene
        session()->forget('subsection');

        //dd(session()->get('section'));
        //obtenemos los datos del uvas
        /*[TO-DO] crear los modelos para obenter toda la información sobre los tipos de pedidos*/
        $entregas = FormasEntrega::active()->get();

        return view('delivery.list',compact('entregas'));
    }

    public function show($entregas)
    {
       
        $ident_entrega = Crypt::decrypt($entregas);
        
        if ($ident_entrega == 0) {
            // Si el identificador es 0, creamos una nueva instancia de Clientes sin datos.
            $entregas = new FormasEntrega();
         
        } else {
            // Buscamos los datos del cliente en la base de datos.
            $entregas = FormasEntrega::find($ident_entrega);
    
            // Verificamos si se encontró el cliente en la base de datos.
            if ($entregas) {
                // Si el cliente existe, lo pasamos a la vista.     
                return view('delivery.detail', compact('entregas', 'ident_entrega'));
            } else {
                // Si no se encuentra el cliente, puedes redirigir a otra página con un mensaje de error.
                dd("Cliente no encontrado");
            }
        }
        return view('delivery.detail', compact('entregas', 'ident_entrega'));
    }

    public function deleteEntrega($id)
    {
        // Encuentra el cliente por su ID
        $entregas = FormasEntrega::find($id);
        
        if ($entregas) {
            // Cambia el valor del campo "activo" a 0
            $entregas->activo = 0;
            $entregas->save();
        } else {
            // Maneja el caso en que el cliente no se encuentre
            // Puedes redirigir o mostrar un mensaje de error
        }
        
        // Redirige de vuelta a la página de clientes
        return redirect('/delivery');
    }



    public function addEntrega(Request $request)
    {
        // Obtener el identificador de la URL
        $ident_ = $request->segment(3); // El número depende del índice del segmento en tu URL
    
        // Buscar el cliente por su ID 
        $entregas = FormasEntrega::find($ident_);
    
        // Obtener el ID del cliente
        if ($entregas != null) {
            $entregas_id = $entregas->id;
        } else {
            $entregas_id = 0;
        }
    
        if ($entregas_id != 0) {
            $entregas->update([
                'nombre' => $request->input('nombre'),
                'icono' => $request->input('icono')
            ]);
    
            return redirect('/delivery');
        } else {
            // Si el cliente no existe, crear uno nuevo
            $entregas = new FormasEntrega([
                'nombre' => $request->input('nombre'),
                'icono' => $request->input('icono')
            ]);
    
            // Guardar el nuevo cliente en la base de datos
            $entregas->save();
    
            return redirect('/delivery');
        }
    }
    

}


