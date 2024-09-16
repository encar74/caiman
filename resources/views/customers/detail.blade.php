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
                    <h1 class="m-0">Clientes</h1>
                </div>
                <a href="{{ route('customers') }}" class="btn btn-primary ml-3"><i class="material-icons">arrow_back</i> Volver al listado</a>
        </div>
    </div>

    <form method="post" id="addCustomerForm" action="{{ route('customers.addCustomer', ['ident' => isset($ident_customer) ? $ident_customer : null]) }}">
    @csrf

    <div class="container-fluid page__container">
        <div class="card card-form">
            <div class="row no-gutters">
     
                <div class="col-lg-12 card-form__body card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre_comercial">NOMBRE COMERCIAL</label>
                                <input id="nombre_comercial" name="nombre_comercial" type="text" class="form-control" placeholder="Nombre comercial" value="{{ $cliente->nombre_comercial }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="razon_social">Razón social</label>
                                <input id="razon_social" name="razon_social" type="text" class="form-control" placeholder="Razón social" value="{{ $cliente->razon_social }}">
                            </div>
                        </div>                        

                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="cif">CIF</label>
                                <input id="cif" name="cif" type="text" class="form-control" placeholder="CIF" value="{{ $cliente->cif }}">
                            </div>
                        </div>                        
                        <div class="col">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="{{ $cliente->email }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="direccion_facturacion">Dirección Facturación</label>
                                <input id="direccion_facturacion" name="direccion_facturacion" type="text" class="form-control" placeholder="Dirección" value="{{ $cliente->direccion_facturacion }}">
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="poblacion">Población</label>
                                <input id="poblacion" name="poblacion" type="text" class="form-control" placeholder="Población" value="{{ $cliente->poblacion }}">
                            </div>
                        </div>                        
                        <div class="col">
                            <div class="form-group">
                                <label for="codigo_postal">Código Postal</label>
                                <input id="codigo_postal" name="codigo_postal" type="text" class="form-control" placeholder="Código Postal" value="{{ $cliente->codigo_postal }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <input id="provincia" name="provincia" type="text" class="form-control" placeholder="Provincia" value="{{ $cliente->provincia }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pais">País</label>
                                <input id="pais" name="pais" type="text" class="form-control" placeholder="País" value="{{ $cliente->pais }}">
                            </div>
                        </div>

                    </div> 
                    
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input id="telefono" name="telefono" type="text" class="form-control" placeholder="Teléfono" value="{{ $cliente->telefono }}">
                            </div>
                        </div>                        
                        <div class="col">
                            <div class="form-group">
                                <label for="contacto">Contacto</label>
                                <input id="contacto" name="contacto" type="text" class="form-control" placeholder="Contacto" value="{{ $cliente->contacto }}">
                            </div>
                        </div>
                    </div>       


                                           
                    <div class="form-group">
                        <label for="desc">Notas</label>
                        <textarea id="desc" name="desc" rows="4" class="form-control" placeholder="notas generales sobre el pedido ...">{{ $cliente->notas }}</textarea>
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



      


        <div class="card">
            <div class="card-header card-header-large bg-white">
                <h4 class="card-header__title">Direcciones de Envío</h4>
            </div>



            <div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>

                
                <table class="table mb-0 thead-border-top-0 table-striped">
                    <thead>
                        <tr>

      
                            <th style="width: 150px;">Nombre</th>
                            <th style="width: 50px; text-align:center; ">Dirección</th>
                            <th style="width: 48px; text-align:center; " >Población</th>
                            <th style="width: 100px; text-align:center">Código Postal</th>
                            <th style="width: 100px; text-align:center">Provincia</th>
                            <th style="width: 100px; text-align:center; ">País</th>

                            <th style="width: 24px;"></th>
                        </tr>
                    </thead>
                    
                    <tbody class="list" id="staff">
                        @if(isset($direccionesCliente))
                        @foreach($direccionesCliente as $direccion)
                        @if($direccion->activo == 1)
                        <tr>
          
                            <td>
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="js-lists-values-employee-name">{{ $direccion->identificador_direccion }}</span>
                                        <!-- Agregar los inputs ocultos aquí -->
                                        <input type="hidden" name="direcciones_nombre[]" value="{{ $direccion->identificador_direccion }}">
                                        <input type="hidden" name="direcciones_direccion[]" value="{{ $direccion->direccion }}">
                                        <input type="hidden" name="direcciones_poblacion[]" value="{{ $direccion->poblacion }}">
                                        <input type="hidden" name="direcciones_codigopostal[]" value="{{ $direccion->codigo_postal }}">
                                        <input type="hidden" name="direcciones_provincia[]" value="{{ $direccion->provincia }}">
                                        <input type="hidden" name="direcciones_pais[]" value="{{ $direccion->pais }}">
                                    </div>
                                </div>
                            </td>
                            <td align='center'>{{ $direccion->direccion }}</td>
                            <td align='center'>{{ $direccion->poblacion }}</td>
                            <td align='center'>{{ $direccion->codigo_postal }}</td>
                            <td align='center'>{{ $direccion->provincia }}</td>
                            <td align='center'>{{ $direccion->pais }}</td>
                            <td>
                            <form id="deleteForm{{ $direccion->id }}" action="{{ route('direccion.delete', ['id' => $direccion->id]) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="#" class="text-muted" onclick="event.preventDefault(); document.getElementById('deleteForm{{ $direccion->id }}').submit();">
                                <i class="material-icons">delete</i>
                            </a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @endif

                    </tbody>
                            
                </table>
            </div>

            

            <div class="card-body text-right">
                
            </div>


        </div> 

        <form method="post" id="addDireccionForm" action="{{ route('customers.addDireccion', ['ident' => isset($ident_customer) ? $ident_customer : null]) }}">
            
     @csrf
        
        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-3 card-body">
                    <p><strong class="headings-color">Nuevo Dirección de Envío</strong></p>
                    <p class="text-muted">Añade una nueva dirección de envío para el cliente</p>
                </div>
                <div class="col-lg-9 card-form__body card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombreDireccion_direccion">Identificador dirección</label>
                                <input type="text" name="nombreDireccion_direccion" class="form-control " id="nombreDireccion_direccion" placeholder="Nombre Dirección" value="" >
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="direccion_direccion">Dirección</label>
                                <input type="text" name="direccion_direccion" class="form-control " id="direccion_direccion" placeholder="Dirección" value="" >
                            </div>
                        </div>

                                       
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="poblacion_direccion">Población</label>
                                <input id="poblacion_direccion" name="poblacion_direccion" type="text" class="form-control" placeholder="Población" value="">
                            </div>
                        </div>                        
                        <div class="col">
                            <div class="form-group">
                                <label for="codigoPostal_direccion">Código Postal</label>
                                <input id="codigoPostal_direccion" type="text" name="codigoPostal_direccion" class="form-control" placeholder="Código Postal" value="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="provincia_direccion">Provincia</label>
                                <input id="provincia_direccion" name="provincia_direccion" type="text" class="form-control" placeholder="Provincia" value="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pais_direccion">País</label>
                                <input id="pais_direccion" name="pais_direccion" type="text" class="form-control" placeholder="País" value="">
                            </div>
                        </div>                        
                    </div>                      

                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="button">&nbsp;</label><br>
                                <button type="submit" class="btn btn-success">Añadir</button>
                            </div>
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
        // Manejar el evento de envío del formulario
        $('#addDireccionForm').submit(function(event) {
            // Evitar el comportamiento predeterminado del formulario
            event.preventDefault();

            // Obtener los valores del formulario
            var nombreDireccion = $('#nombreDireccion_direccion').val();
            var direccion = $('#direccion_direccion').val();
            var poblacion = $('#poblacion_direccion').val();
            var codigoPostal = $('#codigoPostal_direccion').val();
            var provincia = $('#provincia_direccion').val();
            var pais = $('#pais_direccion').val();

            // Crear inputs ocultos con los datos del formulario
            var hiddenInputs = `
                <input type="hidden" name="direcciones_nombre[]" value="${nombreDireccion}">
                <input type="hidden" name="direcciones_direccion[]" value="${direccion}">
                <input type="hidden" name="direcciones_poblacion[]" value="${poblacion}">
                <input type="hidden" name="direcciones_codigopostal[]" value="${codigoPostal}">
                <input type="hidden" name="direcciones_provincia[]" value="${provincia}">
                <input type="hidden" name="direcciones_pais[]" value="${pais}">
            `;

            // Crear una nueva fila de la tabla con los datos del formulario y los inputs ocultos
            // Crear una nueva fila de la tabla con los datos del formulario y los inputs ocultos
var newRow = `
    <tr>
        <td>
            <div class="media align-items-center">
                <div class="media-body">
                    <span class="js-lists-values-employee-name">${nombreDireccion}</span>
                    ${hiddenInputs} <!-- Agregar los inputs ocultos aquí -->
                </div>
            </div>
        </td>
        <td align='center'>${direccion}</td>
        <td align='center'>${poblacion}</td>
        <td align='center'>${codigoPostal}</td>
        <td align='center'>${provincia}</td>
        <td align='center'>${pais}</td>
        <td><a style="cursor: pointer;" class="text-muted delete-row"><i class="material-icons">delete</i></a></td>
    </tr>
`;


            // Agregar la nueva fila a la tabla
            $('.list').append(newRow);

            // Limpiar los campos del formulario
            $('form')[0].reset();
        });

        // Validar campos antes del envío del formulario
        $('#addCustomerForm').submit(function(event) {
            var nombreComercialInput = document.getElementById('nombre_comercial');
            var razonSocialInput = document.getElementById('razon_social');
            var cifInput = document.getElementById('cif');
            var emailInput = document.getElementById('email');
            var direccionFacturacionInput = document.getElementById('direccion_facturacion');
            var poblacionInput = document.getElementById('poblacion');
            var codigoPostalInput = document.getElementById('codigo_postal');
            var provinciaInput = document.getElementById('provincia');
            var paisInput = document.getElementById('pais');
            var telefonoInput = document.getElementById('telefono');
            var contactoInput = document.getElementById('contacto');

            var errors = [];

            if (!nombreComercialInput.value.trim()) {
                errors.push('Por favor, ingrese un nombre comercial.');
            }

            if (!razonSocialInput.value.trim()) {
                errors.push('Por favor, ingrese una razón social.');
            }

            if (!cifInput.value.trim()) {
                errors.push('Por favor, ingrese un CIF.');
            }

            if (!emailInput.value.trim()) {
                errors.push('Por favor, ingrese un email.');
            }

            if (!direccionFacturacionInput.value.trim()) {
                errors.push('Por favor, ingrese una dirección de facturación.');
            }

            if (!poblacionInput.value.trim()) {
                errors.push('Por favor, ingrese una población.');
            }

            if (!codigoPostalInput.value.trim()) {
                errors.push('Por favor, ingrese un código postal.');
            }

            if (!provinciaInput.value.trim()) {
                errors.push('Por favor, ingrese una provincia.');
            }

            if (!paisInput.value.trim()) {
                errors.push('Por favor, ingrese un país.');
            }

            if (!telefonoInput.value.trim()) {
                errors.push('Por favor, ingrese un teléfono.');
            }

            if (!contactoInput.value.trim()) {
                errors.push('Por favor, ingrese un contacto.');
            }

            if (errors.length > 0) {
                event.preventDefault();
                alert(errors.join('\n'));
            }
        });

        // Agregar evento de clic a los botones de la papelera para eliminar filas
        $('.list').on('click', '.delete-row', function() {
            // Eliminar la fila en el cliente
            $(this).closest('tr').remove();
        });
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