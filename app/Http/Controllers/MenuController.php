<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MenuController extends Controller
{
    public static function menusPedidos()
    {
        //[TO-DO] tenemos que hacer la consulta para obtener todos los tipos de pedidos
        $tiposPedido = new Collection();
     
        $tipoPedido = new Collection();
        $tipoPedido->id = 1;
        $tipoPedido->nombre = "Mermeladas y Conservas";
        $tipoPedido->url = 'mermeladas-conservas';
        $tiposPedido->push($tipoPedido);

        $tipoPedido = new Collection();
        $tipoPedido->id = 2;
        $tipoPedido->nombre = "Campañas";
        $tipoPedido->url = 'campanas';
        $tiposPedido->push($tipoPedido);

        $tipoPedido = new Collection();
        $tipoPedido->id = 3;
        $tipoPedido->nombre = "Noche Vieja ";
        $tipoPedido->url = 'noche-vieja';
        $tiposPedido->push($tipoPedido);

       return $tiposPedido;
    }
}
