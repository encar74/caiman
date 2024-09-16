<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\GrapeController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|

*/



Route::middleware([    'auth:sanctum',    config('jetstream.auth_session'),    'verified',])->group(function () {

    //Route::get('/dashboard', function () {        return view('dashboard');    })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

   // Route::get('/', function () { return view('dashboard');    });

   Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);





    //ORDERS
    Route::group(['prefix' => 'orders'], function () {

        Route::get('/{tipo}' , [OrdersController::class,'index'])->name('orders.tipo');

        Route::get('/detail/{ident}' , [OrdersController::class,'show'])->name('orders.ident');
        
        Route::post('detail/{ident}/get-direcciones', [OrdersController::class, 'getDirecciones'])->name('orders.getDirecciones');

        Route::post('detail/{ident}/getDatosArticulo', [OrdersController::class, 'getDatosArticulo'])->name('orders.getDatosArticulo');

        Route::post('detail/{ident}/add-pedido', [OrdersController::class, 'addPedido'])->name('orders.addPedido');

        Route::post('detail/{ident}/delete-Linea', [OrdersController::class, 'deleteLinea'])->name('orders.deleteLinea');

        Route::post('getIva', [OrdersController::class, 'getIva'])->name('orders.getIva');

        Route::post('/{id}/delete', [OrdersController::class, 'deleteOrder'])->name('orders.delete');

        Route::get('detail/{ident}/generar-pdf', [OrdersController::class, 'generarPdf'])->name('orders.generarPdf');

        Route::get('detail/{ident}/enviar-mail', [OrdersController::class, 'enviarMail'])->name('orders.enviarMail');

    });


    //PRODUCTS
    Route::group(['prefix' => 'products'], function () {

        Route::get('/' , [ProductsController::class,'index'])->name('products');

        Route::get('/detail/{ident}' , [ProductsController::class,'show'])->name('products.ident');

        Route::post('/products/{ident}/add-producto', [ProductsController::class, 'addProducto'])->name('products.addProducto');

        Route::post('/products/{id}/delete', [ProductsController::class, 'deleteProduct'])->name('products.delete');
        
    });   
    

    //CUSTOMER
    Route::group(['prefix' => 'customers'], function () {

        Route::get('/' , [CustomersController::class,'index'])->name('customers');

        Route::get('/detail/{ident}' , [CustomersController::class,'show'])->name('customers.ident');

        Route::post('/customers/{ident}/add-direccion', [CustomersController::class, 'addDireccion'])->name('customers.addDireccion');

        Route::post('/customers/{ident}/add-customer', [CustomersController::class, 'addCustomer'])->name('customers.addCustomer');

        Route::post('/customers/{id}/delete', [CustomersController::class, 'deleteCustomer'])->name('customers.delete');

        Route::post('/detail/{id}/delete', [CustomersController::class, 'deleteDireccion'])->name('direccion.delete');

   
    });      
    
    //GRAPE
    Route::group(['prefix' => 'grapes'], function () {

        Route::get('/' , [GrapeController::class,'index'])->name('grapes');

        Route::get('/detail/{ident}' , [GrapeController::class,'show'])->name('grapes.ident');

        Route::post('/grapes/{ident}/add-uvas', [GrapeController::class, 'addUvas'])->name('grapes.addUvas');

        Route::post('/grapes/{id}/delete', [GrapeController::class, 'deleteUvas'])->name('grapes.delete');
        
    });       


      //DELIVERY
      Route::group(['prefix' => 'delivery'], function () {

        Route::get('/' , [DeliveryController::class,'index'])->name('delivery');

        Route::get('/detail/{ident}' , [DeliveryController::class,'show'])->name('delivery.ident');

        Route::post('/delivery/{ident}/add-entrega', [DeliveryController::class, 'addEntrega'])->name('delivery.addEntrega');

        Route::post('/delivery/{id}/delete', [DeliveryController::class, 'deleteEntrega'])->name('delivery.delete');
        
    });  

});
