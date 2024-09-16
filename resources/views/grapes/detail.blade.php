@extends('layouts.main')
@push('css')
    <!-- Select2 -->
    <link type="text/css" href="{{ asset('assets/css/vendor-select2.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/vendor-select2.rtl.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

@endpush

@section('content')
@include('includes.errors')
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center">
                <div class="flex flex-edit">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                            
                            <li class="breadcrumb-item active" aria-current="page">Clientes</li>
                        </ol>
                    </nav><div class='clearfix'></div>
                    <h1 class="m-0">Productos</h1>
                </div>
                <a href="{{ route('grapes') }}" class="btn btn-primary ml-3"><i class="material-icons">arrow_back</i> Volver al listado</a>
        </div>
    </div>

    <form method="post" id="addCustomerForm" action="{{ route('products.addProducto', ['ident' => isset($ident_uvas) ? $ident_uvas : null]) }}">
    @csrf

    <div class="container-fluid page__container">
        <div class="card card-form">
            <div class="row no-gutters">
     
                <div class="col-lg-12 card-form__body card-body">
                    <div class="row">
                       
                        <div class="col">
                            <div class="form-group">
                                <label for="referencia">Referencia</label>
                                <input id="referencia" name="referencia" type="text" class="form-control" placeholder="Referencia" value="{{ $uvas->referencia }}">
                            </div>
                        </div>               
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre_articulo" name="nombre_articulo" type="text" class="form-control" placeholder="Nombre" value="{{ $uvas->nombre_articulo }}">
                            </div>
                        </div>             
                        <div class="col">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input id="precio" name="precio" type="text" class="form-control" placeholder="Precio" value="{{ $uvas->precio }}">
                            </div>
                        </div>   
                        <div class="col">
                            <div class="form-group">
                                <label for="iva">Iva</label>
                                <input id="iva" name="iva" type="text" class="form-control" placeholder="Iva" value="{{ $uvas->iva }}">
                            </div>
                        </div>  
                        <div class="col">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input id="stock" name="stock" type="text" class="form-control" placeholder="Stock" value="{{ $uvas->stock }}">
                            </div>
                        </div>   
                        <input id="tipo_producto" name="tipo_producto" type="hidden" value="3">

                    </div>

                                           
                    <div class="form-group">
                        <label for="desc">Notas</label>
                        <textarea id="desc" name="desc" rows="4" class="form-control" placeholder="notas generales sobre el pedido ...">{{ $uvas->notas }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-3">
                                                       
                        </div>
                        <div class="col-9">
                            <div class=" pull-right">
                                
                                    
                                    <button type="submit" id="guardarCliente" class="btn btn-success"> <i class="material-icons mr-1">save</i> Guardar</button>
                                
                            </div>  
                        </div>
                    </div>

        
                </div>
            </div>
        </div>    
        
</form>

<script>
        $(document).ready(function() {

try {
    document.getElementById('addCustomerForm').addEventListener('submit', function(event) {
        var referenciaInput = document.getElementById('referencia');
        var nombreInput = document.getElementById('nombre_articulo');
        var precioInput = document.getElementById('precio');
        
        var errors = [];

        if (!referenciaInput.value.trim()) {
            errors.push('Por favor, ingrese una referencia.');
        }
        
        if (!nombreInput.value.trim()) {
            errors.push('Por favor, ingrese un nombre.');
        }

        if (!precioInput.value.trim()) {
            errors.push('Por favor, ingrese un precio.');
        }

        if (errors.length > 0) {
            event.preventDefault();
            alert(errors.join('\n'));
        }
    });
} catch (error) {
                console.error('Error en la página:', error);
                window.history.back(); // Redirigir a la página anterior en caso de error
            }
</script>






@endsection


@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush