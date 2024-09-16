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
                            
                            <li class="breadcrumb-item active" aria-current="page">Formas de entrega</li>
                        </ol>
                    </nav><div class='clearfix'></div>
                    <h1 class="m-0">Formas de entrega</h1>
                </div>
                <a href="{{ route('delivery') }}" class="btn btn-primary ml-3"><i class="material-icons">arrow_back</i> Volver al listado</a>
        </div>
    </div>

    <form method="post" id="addCustomerForm" action="{{ route('delivery.addEntrega', ['ident' => isset($ident_entrega) ? $ident_entrega : null]) }}">
    @csrf

    <div class="container-fluid page__container">
        <div class="card card-form">
            <div class="row no-gutters">
     
                <div class="col-lg-12 card-form__body card-body">
                    <div class="row">
                       
           
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" value="{{ $entregas->nombre }}">
                            </div>
                        </div>             

                        <div class="col">
                        <div class="form-group">
                            <label for="icono">Método de entrega</label>
                            <select id="icono" name="icono" class="form-control">
                                <option value="local_shipping" {{ $entregas->icono == 'local_shipping' ? 'selected' : '' }}>Vienen a recogerlo</option>
                                <option value="directions_run" {{ $entregas->icono == 'directions_run' ? 'selected' : '' }}>TIPSA</option>
                                <option value="person_walking" {{ $entregas->icono == 'person_walking' ? 'selected' : '' }}>Llevar en mano</option>
                                <option value="otro" {{ $entregas->icono == 'otro' ? 'selected' : '' }}>Otro método</option>
                            </select>
                        </div>
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
    document.getElementById('addCustomerForm').addEventListener('submit', function(event) {
        try {
        var nombreInput = document.getElementById('nombre');
        if (!nombreInput.value.trim()) {
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