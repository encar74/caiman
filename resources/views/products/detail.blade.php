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
                <a href="{{ route('products') }}" class="btn btn-primary ml-3"><i class="material-icons">arrow_back</i> Volver al listado</a>
        </div>
    </div>

    <form method="post" id="addCustomerForm" action="{{ route('products.addProducto', ['ident' => isset($ident_producto) ? $ident_producto : null]) }}">
    @csrf

    <div class="container-fluid page__container">
        <div class="card card-form">
            <div class="row no-gutters">
     
                <div class="col-lg-12 card-form__body card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                            <label for="tipo_producto">TIPO PRODUCTO</label>
                            <select id="tipo_producto" name="tipo_producto" class="form-control">
                            <option value="1" {{ (string) $producto->tipo_producto === '1' ? 'selected' : '' }}>Campaña</option>
                            <option value="2" {{ (string) $producto->tipo_producto === '2' ? 'selected' : '' }}>Mermeladas</option>

                            </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="referencia">Referencia</label>
                                <input id="referencia" name="referencia" type="text" class="form-control" placeholder="Referencia" value="{{ $producto->referencia }}">
                            </div>
                        </div>               
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre_articulo">Nombre artículo</label>
                                <input id="nombre_articulo" name="nombre_articulo" type="text" class="form-control" placeholder="Nombre artículo" value="{{ $producto->nombre_articulo }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="iva">IVA</label>
                                <input id="iva" name="iva" type="text" class="form-control" placeholder="0" value="{{ $producto->iva }}">
                            </div>
                        </div>                 

                    </div>
                    <div class="row">
                    
                        <div class="col">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input id="precio" name="precio" type="text" class="form-control" placeholder="Precio" value="{{ $producto->precio }}">
                            </div>
                        </div>     
                        <div class="col">
                            <div class="form-group">
                                <label for="kg_caja">Kg/caja</label>
                                <input id="kg_caja" name="kg_caja" type="text" class="form-control" placeholder="Kg/caja" value="{{ $producto->kg_caja }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input id="stock" name="stock" type="text" class="form-control" placeholder="Stock" value="{{ $producto->stock }}">
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="trazabilidad">Trazabilidad</label>
                                <input id="trazabilidad" name="trazabilidad" type="text" class="form-control" placeholder="Trazabilidad" value="{{ $producto->trazabilidad }}">
                            </div>
                        </div>



                    </div> 

                                           
                    <div class="form-group">
                        <label for="desc">Notas</label>
                        <textarea id="desc" name="desc" rows="4" class="form-control" placeholder="notas generales sobre el pedido ...">{{ $producto->notas }}</textarea>
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
    $(document).ready(function(){
        try {
        $('#tipo_producto').change(function(){
            var selectedOption = $(this).val();
            if(selectedOption === '2') {
                $('#trazabilidad').val('').hide();
                // Ocultar los títulos de los campos también
                $('label[for="trazabilidad"]').hide();
            } else {
                $('#trazabilidad').show();
                $('#kg_caja').show();
                // Mostrar los títulos de los campos
                $('label[for="trazabilidad"]').show();
            }
        });
    } catch (error) {
                console.error('Error en la página:', error);
                window.history.back(); // Redirigir a la página anterior en caso de error
            }
    });

    
</script>

<script>
    $(document).ready(function() {
        function checkTipoProducto() {
            var selectedOption = $('#tipo_producto').val();
            if (selectedOption === '2') {
                $('#trazabilidad').val('').hide();
                // Ocultar los títulos de los campos también
                $('label[for="trazabilidad"]').hide();
            } else {
                $('#trazabilidad').show();
                // Mostrar los títulos de los campos
                $('label[for="trazabilidad"]').show();
            }
        }

        // Comprobación inicial cuando se carga la página
        checkTipoProducto();

        // Comprobación al cambiar la selección
        $('#tipo_producto').change(function() {
            checkTipoProducto();
        });
    });
</script>


<script>
        $(document).ready(function(){
            try{
            $('#tipo_producto').change(function(){
                var selectedOption = $(this).val();
                if(selectedOption === '2') {
                    $('#trazabilidad').val('').hide();
                    // Ocultar los títulos de los campos también
                    $('label[for="trazabilidad"]').hide();
                } else {
                    $('#trazabilidad').show();
                    // Mostrar los títulos de los campos
                    $('label[for="trazabilidad"]').show();
                }
            });
        } catch (error) {
                console.error('Error en la página:', error);
                window.history.back(); // Redirigir a la página anterior en caso de error
            }
        });

        document.getElementById('addCustomerForm').addEventListener('submit', function(event) {
            try{
            var referenciaInput = document.getElementById('referencia');
            var nombreArticuloInput = document.getElementById('nombre_articulo');
            var precioInput = document.getElementById('precio');
            var trazabilidadInput = document.getElementById('trazabilidad');
            var kgCajaInput = document.getElementById('kg_caja');
            var stockInput = document.getElementById('stock');

            var errors = [];

            if (!referenciaInput.value.trim()) {
                errors.push('Por favor, ingrese una referencia.');
            }

            if (!nombreArticuloInput.value.trim()) {
                errors.push('Por favor, ingrese un nombre de artículo.');
            }

            if (!precioInput.value.trim()) {
                errors.push('Por favor, ingrese un precio.');
            }

            if (!stockInput.value.trim()) {
                errors.push('Por favor, ingrese un stock.');
            }

            if (trazabilidadInput.style.display !== 'none' && !trazabilidadInput.value.trim()) {
                errors.push('Por favor, ingrese la trazabilidad.');
            }

            if (kgCajaInput.style.display !== 'none' && !kgCajaInput.value.trim()) {
                errors.push('Por favor, ingrese los kilogramos por caja.');
            }

            if (errors.length > 0) {
                event.preventDefault();
                alert('Por favor, rellena todos los campos');
            }
        } catch (error) {
                console.error('Error en la página:', error);
                window.history.back(); // Redirigir a la página anterior en caso de error
            }
        });
        
    </script>

@endsection


@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush