<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Productos;
use App\Models\Pedidos;
use App\Models\Linea_pedidos;
use App\Models\Clientes;

class DashboardController extends Controller
{
    public function index()
    {
        $productos = Productos::active()->get()->toArray();
        $pedidos = Pedidos::active()->get()->toArray();
        $lineas = Linea_pedidos::active()->get()->toArray();
        $clientes = Clientes::active()->get()->toArray();

        return view('dashboard', compact('productos','pedidos','lineas','clientes'));
    }
}


