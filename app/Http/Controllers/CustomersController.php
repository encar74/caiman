<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Clientes;
use App\Models\Direcciones;




class CustomersController extends Controller
{
    public function __construct()
    {
        session()->put('section', 'customer');

        // Quitamos la subsection, porque esta sección no tiene
        session()->forget('subsection');
    }

    public function index(Request $request)
    {
        session()->put('section', 'customer');

        // Quitamos la subsection, porque esta sección no tiene
        session()->forget('subsection');

        // Obtenemos los datos del producto
        $customers = Clientes::active()->get();

        return view('customers.list', compact('customers'));
    }

    /*
     * Display a detail of Order
     * @param  ident
     * @return blade view | ajax view
     */
    public function show($customer)
    {
        
        $ident_customer = Crypt::decrypt($customer);

        if ($ident_customer == 0) {
            // Si el identificador es 0, creamos una nueva instancia de Clientes sin datos.
            $cliente = new Clientes();
         
        } else {
            // Buscamos los datos del cliente en la base de datos.
            $cliente = Clientes::find($ident_customer);
    
            // Verificamos si se encontró el cliente en la base de datos.
            if ($cliente) {
                // Si el cliente existe, lo pasamos a la vista.
                // return view('customers.detail', compact('cliente'));
                $direccionesCliente = $cliente->direcciones()->get();
              
                return view('customers.detail', compact('cliente', 'direccionesCliente', 'ident_customer'));
            } else {
                // Si no se encuentra el cliente, puedes redirigir a otra página con un mensaje de error.
                dd("Cliente no encontrado");
            }
        }
        
        // Pasamos el objeto $customer a la vista.
        return view('customers.detail', compact('cliente', 'ident_customer'));

    }
    

public function deleteCustomer($id)
{
    // Encuentra el cliente por su ID
    $cliente = Clientes::find($id);
    
    if ($cliente) {
        // Cambia el valor del campo "activo" a 0
        $cliente->activo = 0;
        $cliente->save();
    } else {
        // Maneja el caso en que el cliente no se encuentre
        // Puedes redirigir o mostrar un mensaje de error
    }
    
    // Redirige de vuelta a la página de clientes
    return redirect('/customers');
}

public function deleteDireccion($id)
{
    // Encuentra la dirección por su ID
    $direccion = Direcciones::find($id);
    
    if ($direccion) {
        // Cambia el valor del campo "activo" a 0
        $direccion->activo = 0;
        $direccion->save();
    } else {
        // Maneja el caso en que la dirección no se encuentre
        // Puedes redirigir o mostrar un mensaje de error
    }
    
    // Redirige de vuelta a la página de clientes
    return redirect('/customers');
}




public function addDireccion(Request $request, $ident)
{
    // Encontrar el cliente por su ID
    $cliente = Clientes::find($ident);

    // Verificar si el cliente existe y si se proporcionaron datos de direcciones
    if ($cliente && $request->has('direcciones_nombre')) {
        // Obtener los datos de las nuevas direcciones desde la solicitud
        $nombresDirecciones = $request->input('direcciones_nombre');
        $direcciones = $request->input('direcciones_direccion');
        $poblaciones = $request->input('direcciones_poblacion');
        $codigosPostales = $request->input('direcciones_codigopostal');
        $provincias = $request->input('direcciones_provincia');
        $paises = $request->input('direcciones_pais');

        // Obtener todas las direcciones asociadas al cliente
        $direccionesCliente = $cliente->direcciones;

        // Recorrer los datos de las nuevas direcciones y crear o actualizar cada una
        foreach ($nombresDirecciones as $key => $nombreDireccion) {
            // Verificar si se proporcionan todos los datos necesarios
            if (isset($direcciones[$key], $poblaciones[$key], $codigosPostales[$key], $provincias[$key], $paises[$key])) {
                // Buscar la dirección existente por su identificador
                $direccionExistente = $direccionesCliente->where('identificador_direccion', $nombreDireccion)->first();

                if ($direccionExistente) {
                    // Si la dirección existe, actualizar sus valores
                    $direccionExistente->update([
                        'direccion' => $direcciones[$key],
                        'poblacion' => $poblaciones[$key],
                        'codigo_postal' => $codigosPostales[$key],
                        'provincia' => $provincias[$key],
                        'pais' => $paises[$key],
                        'activo' => 1 // Marcar la dirección como activa
                    ]);
                } else {
                    // Si la dirección no existe, crear una nueva
                    $cliente->direcciones()->create([
                        'identificador_direccion' => $nombreDireccion,
                        'direccion' => $direcciones[$key],
                        'poblacion' => $poblaciones[$key],
                        'codigo_postal' => $codigosPostales[$key],
                        'provincia' => $provincias[$key],
                        'pais' => $paises[$key],
                        'activo' => 1 // Marcar la dirección como activa
                    ]);
                }
            }
        }

        // Marcar como inactivas las direcciones que no están en la solicitud
        foreach ($direccionesCliente as $direccion) {
            if (!in_array($direccion->identificador_direccion, $nombresDirecciones)) {
                $direccion->activo = 0;
                $direccion->save();
            }
        }
    }
}





public function addCustomer(Request $request)
{
    // Obtener el identificador de la URL
    $ident_ = $request->segment(3); // El número depende del índice del segmento en tu URL

    // Buscar el cliente por su ID 
    $cliente = Clientes::find($ident_);


    // Obtener el ID del cliente
    if ($cliente != null) {
    $cliente_id = $cliente->id;
    }else{
    $cliente_id=0;
    }



    if ($cliente_id!=0) {

        $cliente->update([
            'nombre_comercial' => $request->input('nombre_comercial'),
            'razon_social' => $request->input('razon_social'),
            'cif' => $request->input('cif'),
            'email' => $request->input('email'),
            'direccion_facturacion' => $request->input('direccion_facturacion'),
            'poblacion' => $request->input('poblacion'),
            'codigo_postal' => $request->input('codigo_postal'),
            'provincia' => $request->input('provincia'),
            'pais' => $request->input('pais'),
            'telefono' => $request->input('telefono'),
            'contacto' => $request->input('contacto'),
            'notas' => $request->input('desc'),
        ]);

        // Llamar a la función addDireccion para guardar o actualizar las direcciones del cliente
        $this->addDireccion($request, $cliente_id);

        return redirect('/customers');
    } else {
        // Si el cliente no existe, crear uno nuevo
        $cliente = new Clientes([
            'nombre_comercial' => $request->input('nombre_comercial'),
            'razon_social' => $request->input('razon_social'),
            'cif' => $request->input('cif'),
            'email' => $request->input('email'),
            'direccion_facturacion' => $request->input('direccion_facturacion'),
            'poblacion' => $request->input('poblacion'),
            'codigo_postal' => $request->input('codigo_postal'),
            'provincia' => $request->input('provincia'),
            'pais' => $request->input('pais'),
            'telefono' => $request->input('telefono'),
            'contacto' => $request->input('contacto'),
            'notas' => $request->input('desc'),
        ]);

        // Guardar el nuevo cliente en la base de datos
        $cliente->save();
        // Obtener el ID del cliente recién creado
        $cliente_id = $cliente->id;

        // Llamar a la función addDireccion para guardar o actualizar las direcciones del cliente
        $this->addDireccion($request, $cliente_id);

        return redirect('/customers');
    }
}




}