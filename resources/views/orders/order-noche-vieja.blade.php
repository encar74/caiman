@extends('layouts.main')
@push('css')
    <!-- Select2 -->
    <link type="text/css" href="{{ asset('assets/css/vendor-select2.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/vendor-select2.rtl.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
    <meta charset="UTF-8">

@endpush

@section('content')
@include('includes.errors')
    @include('orders.header')
    <div id="formContainer">
    <form method="post" id="addPedidoForm" action="{{ route('orders.addPedido', ['ident' => isset($ident_order) ? $ident_order : null]) }}">
            
        @csrf

        <div class="container-fluid page__container">
        <div class="card card-form">
            <div class="row no-gutters">
            <input type="hidden" name="tipo" value="3">
                <div class="col-lg-12 card-form__body card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="cliente">Cliente</label>
                                <label for="cliente">Cliente</label>
                                <select id="cliente" name="cliente" data-toggle="select" class="form-control">
                            @foreach ($clientes as $key => $value)
                                @php
                                    $selected = (isset($orders) && isset($orders->id_cliente) && $orders->id_cliente == $key) ? 'selected' : '';
                                @endphp
                                <option value="{{ $key }}" {{ $selected }}>{{ $value }}</option>
                            @endforeach
                               </select>
                            </div>
                        </div>

                        <div class="col">
                    <div class="form-group">
                        <label for="destino">Destino</label>
                        <select id="destino" name="destino" data-toggle="select" class="form-control">
                        <option value="" selected>Selecciona un destino</option>
                        @foreach($direcciones as $direccion)
                            @php
                                $selected = (isset($orders) && isset($orders->id_direccion) && $orders->id_direccion == $direccion->id) ? 'selected' : '';
                            @endphp
                            <option value="{{ $direccion->id }}" {{ $selected }}>{{ $direccion->direccion }}</option>
                        @endforeach
                    </select>

                    </div>
                </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="entrega">Forma de Entrega</label>
                                <select id="entrega" name="entrega" data-toggle="select" class="form-control">
                                <option selected="">Selecciona forma de entrega</option>
                                <option {{ isset($orders) && $orders->transporte == 'Vienen a recogerlo' ? 'selected' : '' }}>Vienen a recogerlo</option>
                                <option {{ isset($orders) && $orders->transporte == 'TIPSA' ? 'selected' : '' }}>TIPSA</option>
                                <option {{ isset($orders) && $orders->transporte == 'Llevar en mano' ? 'selected' : '' }}>Llevar en mano</option>
                                <option {{ isset($orders) && $orders->transporte == 'Otro' ? 'selected' : '' }}>Otro método</option>
                            </select>
                            </div>
                        </div>                        
                        <div class="col">
                            <div class="form-group">
                                <label for="fecha_pedido">Fecha de pedido</label>
                                <input name="fecha_pedido" id="fecha_pedido" type="text" class="form-control" placeholder="Flatpickr example" data-toggle="flatpickr" value="{{ isset($orders) ? $orders->fecha : 'today' }}"  data-flatpickr-alt-format="d/m/Y" data-flatpickr-date-format="d/m/Y">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="fecha_entrega">Fecha de entrega</label>
                                <input name="fecha_entrega" id="fecha_entrega" type="text" class="form-control" placeholder="Flatpickr example" data-toggle="flatpickr" value="{{ isset($orders) ? $orders->fecha_entrega : 'today' }}"  data-flatpickr-alt-format="d/m/Y" data-flatpickr-date-format="d/m/Y">
                            </div>
                        </div>
                    </div>                                    
                                           
                    <div class="form-group">
                        <label for="desc">Notas</label>
                        <textarea name="notas" id="notas" rows="4" class="form-control" placeholder="notas generales sobre el pedido ...">{{ isset($orders) ? $orders->notas : '' }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select name="estado" id="estado" data-toggle="select" class="form-control">
                                <option selected="">Selecciona un estado</option>
                                <option value="1" {{ isset($orders) && $orders->estado == 1 ? 'selected' : '' }}>Borrador</option>
                                <option value="2" {{ isset($orders) && $orders->estado == 2 ? 'selected' : '' }}>Preparado</option>
                                <option value="3" {{ isset($orders) && $orders->estado == 3 ? 'selected' : '' }}>Enviado</option>
                                <option value="4" {{ isset($orders) && $orders->estado == 4 ? 'selected' : '' }}>Confirmado</option>
                            </select>


                            </div>                            
                        </div>
                        <div class="col-9">
                            <div class=" pull-right">
                                
                                    <label for="estado">&nbsp;</label>
                                    <br>
                                   <!-- <button type="button" class="btn btn-secondary">Guardar Borrador</button> -->
                                   @if ($ident_order != 0)
                                        <a href="{{ route('orders.generarPdf', ['ident' => $ident_order]) }}" class="btn btn-light" target='_blank'>
                                            <i class="material-icons mr-1">send</i> Generar Albarán
                                        </a>
                                        <a href="{{ route('orders.enviarMail', ['ident' => $ident_order]) }}" class="btn btn-light">
                                            <i class="material-icons mr-1">send</i> Enviar Proforma
                                        </a>
                                    @endif

                                   <!-- <button type="button" class="btn btn-success"> <i class="material-icons mr-1">send</i> Guardar y Enviar</button> -->
                                    <button type="submit" id="guardarPedido" class="btn btn-success"> <i class="material-icons mr-1">save</i> Guardar</button>
                            </div>  
                        </div>
                    </div>
        
                </div>
            </div>
        </div>  
        
        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-3 card-body">
                    <p><strong class="headings-color">Nuevo Artículo</strong></p>
                    <p class="text-muted">Añade un nuevo artículo al pedido</p>
                    <div class="form-group">
                        <label for="desc_linea">Notas</label>
                        <textarea id="desc_linea" rows="4" class="form-control" placeholder="notas sobre el nuevo artículo"></textarea>
                    </div>                    
                </div>
                <div class="col-lg-9 card-form__body card-body">
                    <div class="row"> 
                        <div class="col">
                            <div class="form-group">
                                <label for="articulo">Variedad uva</label>
                                <select id="articulo" data-toggle="select" class="form-control">
                            <option value="default" selected>Selecciona un producto</option>
                            @foreach ($productos as $productoId => $producto)
                                @if ($producto['tipo_producto'] == '3')
                                    <option value="{{ $productoId }}" data-articulo-id="{{ $producto['id'] }}" data-iva="{{ $producto['iva'] }}">{{ $producto['nombre_articulo'] }}</option>
                                @endif
                            @endforeach
                        </select>
                            </div>
                        </div>    
                        <div class="col">
                            <div class="form-group">
                                <label for="referencia">Referencia</label>
                                <input type="text" class="form-control input-sm" id="referencia" placeholder="Referencia" value="" >
                            </div>
                        </div>     
                    </div>
                    <div class="row">               
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" class="form-control input-sm" id="cantidad" placeholder="1" value="1" >
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="precio">Precio/€</label>
                                <input type="number" class="form-control input-sm" id="precio" placeholder="0" value="" step="0.01" min="0" pattern="^\d+(\.\d{1,2})?$">
                            </div>
                        </div>
                        <div class="col-lg-2">
                        <div class="flex" style="display:block !important">
                        <label for="subscribe">Comisión</label><br>
                        <div class="custom-control custom-checkbox-toggle custom-control-inline mr-1">
                            <input checked="" type="checkbox" id="subscribe" class="custom-control-input" onchange="toggleComision()">
                            <label class="custom-control-label" for="subscribe" id="subscribeLabel">Si</label>
                        </div>
                        <label for="subscribe" id="checkboxid" class="mb-0">Si</label>
                    </div>

                    </div>
                    <input type="hidden" id="comision" name="comision" value="1">
                    <script>
                    function toggleComision() {
                        var checkbox = document.getElementById("subscribe");
                        var label = document.getElementById("checkboxid");
                        
                        if (checkbox.checked) {
                            label.textContent = "Si";
                            // Si el checkbox está marcado, establece el valor del campo de comisión en 1
                            document.getElementById("comision").value = "1";
                        } else {
                            label.textContent = "No";
                            // Si el checkbox no está marcado, establece el valor del campo de comisión en 0
                            document.getElementById("comision").value = "0";
                        }
                    }
                </script>



                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="button">&nbsp;</label><br>
                                <button type="submit" id="btnAdd" class="btn btn-success">Añadir</button>
                            </div>
                        </div>                        
                    </div>

                   
                </div>
            </div>
        </div>

      


        <div class="card">
            <div class="card-header card-header-large bg-white">
                <h4 class="card-header__title">Líneas de pedido</h4>
            </div>



            <div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>

                
                <table class="table mb-0 thead-border-top-0 table-striped">
                    <thead>
                        <tr>

                            <th style="width: 18px;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input js-toggle-check-all" data-target="#staff" id="customCheckAll">
                                    <label class="custom-control-label" for="customCheckAll"><span class="text-hide">Toggle all</span></label>
                                </div>
                            </th>
                            <th style="width: 150px;">Variedad Uva</th>
                            <th style="width: 150px;">Referencia</th>
                            <th style="width: 50px; text-align:center;">Cantidad</th>
                            <th style="width: 48px; text-align:center;" >Precio</th>
                            <th style="width: 48px; text-align:center;" >Comisión</th>
                            <th style="width: 100px; text-align:center">Total</th>
                            <th style="width: 100px; text-align:center">% IVA</th>
                            <th style="width: 100px; text-align:center;">Total Línea</th>
                            <td style="width: 24px;"></td>

                            <th style="width: 24px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="staff">

                    
                                        

                @if(isset($lineasPedido) && count($lineasPedido) > 0)
                @foreach($lineasPedido as $index => $linea)
                    @php
                    $total = $linea->cantidad * $linea->precio;

                // Encuentra el producto correspondiente usando el articulo_id del linea
                $productoKey = array_search($linea->articulo_id, array_column($productos, 'id'));
                $productoIva = $productoKey !== false ? $productos[$productoKey]['iva'] : 0;
                $productoId = $productoKey !== false ? $productos[$productoKey]['id'] : 0;

                // Calcula el IVA
                $iva = $total * ($productoIva / 100);

                // Suma el IVA al total
                $totalConIva = $total + $iva;
                @endphp
                <tr data-linea-pedido-id="{{ $linea->id }}">
                <input type="hidden" name="lineas_pedido[{{ $index }}][id]" value="{{ $linea->id }}">
                <td>
                <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck1_{{ $index }}">
                <label class="custom-control-label" for="customCheck1_{{ $index }}"><span class="text-hide">Check</span></label>
                </div>
                </td>
                <td>
                <div class="media align-items-center">
                <div class="media-body">
                    <span class="js-lists-values-employee-name">{{ $linea->articulo }}</span>
                    <!-- Agregar input oculto para el nombre del artículo -->
                    <input type="hidden" name="lineas_pedido[{{ $index }}][producto_id]" value="{{ $productoId }}">
                    <input type="hidden" name="lineas_pedido[{{ $index }}][articulo]" value="{{ $linea->articulo }}">
                    <input type="hidden" name="lineas_pedido[{{ $index }}][cantidad]" value="{{ $linea->cantidad }}">
                    <input type="hidden" name="lineas_pedido[{{ $index }}][precio]" value="{{ $linea->precio }}">
                    <input type="hidden" name="lineas_pedido[{{ $index }}][comision]" value="{{ $linea->comision }}">
                    <input type="hidden" name="lineas_pedido[{{ $index }}][referencia]" value="{{ $linea->referencia }}">
                </div>
                </div>
                </td>
                <td align='center'>{{ $linea->referencia }}</td>
                <td align='center'>{{ $linea->cantidad }}</td>
                <td align='center'>{{ number_format($linea->precio, 2) }}</td>
                <td align='center'>
                    {{ $linea->comision == 1 ? 'Sí' : 'No' }}
                </td>
                <td align='center'>{{ number_format($total, 2) }}€</td>
                <td align='center'>{{ $productoIva }}%</td> 
                <td align='center'>{{ number_format($totalConIva, 2) }}€</td> 
                <td>
                <a href="#" class="text-muted btn-delete">
                <i class="material-icons">delete</i>
                </a>
                </td>
                </tr>
                @endforeach
                @endif


                    
                    <tr>
                        
                        <td></td>
                        <td><strong>TOTALES</strong></td>
                        <td></td>
                        <td></td>
                        <td colspan=2></td>
                        <td id="total" align='center'><span><strong>0€</strong></td>
                        <td align='center'></td>
                        <td id="total_linea" align='center'><span><strong>0€</strong></td>
                        <td></td>

                    </tr>

                </tbody>
                </table>

                </div>


                <div class="card-body text-right">

                </div>


                </div> 
                <div class="card-group">
                <div class="card card-body text-center">

                <div class="d-flex flex-row align-items-center">
                <div class="card-header__title m-0"> <i class="material-icons icon-muted icon-30pt">assessment</i> Base Imponible</div>
                <div class="text-amount ml-auto">0€</div>
                </div>
                </div>
                <div class="card card-body text-center">
                <div class="d-flex flex-row align-items-center">
                <div class="card-header__title m-0"><i class="fa fa-percent icon-muted icon-10pt"></i>&nbsp; Importe IVA</div>
                <div class="text-amount ml-auto">0€</div>
                </div>
                </div>
                <div class="card card-body text-center">
                <div class="d-flex flex-row align-items-center">
                <div class="card-header__title m-0"><i class="material-icons  icon-muted icon-30pt">euro_symbol</i> TOTAL PEDIDO</div>
                <div class="text-amount ml-auto">0€</div>
                <input type="hidden" id="total_pedido_hidden" name="total_pedido_hidden" value="0">
                </div>
                </div>
                </div>

                </div>

                </form>
                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   

                <script>
$(document).ready(function() {
    var baseImponible = 0;
    var importeIVA = 0;
    var totalPedido = 0;

    // Función para calcular los totales
    function calcularTotales() {
        baseImponible = 0;
        importeIVA = 0;
        totalPedido = 0;

        // Iterar sobre cada fila de la tabla de líneas de pedido
        $('.list tr').each(function(index, fila) {
            var totalLinea = parseFloat($(fila).find('td:eq(6)').text().replace('€', '')) || 0;
            var ivaProducto = parseFloat($(fila).find('td:eq(7)').text().replace('%', '')) || 0;
            var totalLineaConIVA = parseFloat($(fila).find('td:eq(8)').text().replace('€', '')) || 0;

            // Sumar el total de la línea a la base imponible
            baseImponible += totalLinea;
            // Calcular el importe del IVA de la línea y sumarlo al total del importe del IVA
            importeIVA += totalLineaConIVA - totalLinea;
            // Sumar el total de la línea con IVA al total del pedido
            totalPedido += totalLineaConIVA;
        });

        // Actualizar los elementos HTML con los nuevos valores
        $('#total').text(baseImponible.toFixed(2) + "€");
        $('.text-amount').eq(0).text(baseImponible.toFixed(2) + "€");

        $('#importe-iva').text(importeIVA.toFixed(2) + "€");
        $('.text-amount').eq(1).text(importeIVA.toFixed(2) + "€");

        $('#total_linea').text(totalPedido.toFixed(2) + "€");
        $('.text-amount').eq(2).text(totalPedido.toFixed(2) + "€");

        $('#total_pedido_hidden').val(totalPedido.toFixed(2)); // Actualizar el valor del input oculto
    }

    // Calcular totales al cargar la página
    calcularTotales();

    // Definir una variable para llevar la cuenta del índice de las líneas de pedido
    var index = {{ count($lineasPedido ?? []) }};

    // Agregar un evento de clic al botón "Añadir"
    $('#btnAdd').click(function(event) {
        event.preventDefault();

        // Obtener los valores del formulario
        var cantidad = parseInt($('#cantidad').val());
        var precio = parseFloat($('#precio').val());
        var referencia = $('#referencia').val();
        var articulo = $('#articulo').find('option:selected').text(); // Obtener el nombre del artículo seleccionado
        var productoId = $('#articulo').find('option:selected').val(); // Obtener el productoId del artículo seleccionado
        productoId++;
        var comision = $('#comision').val();
        var ivaProducto = parseFloat($('#articulo').find('option:selected').data('iva'));

        // Verificar si los campos están rellenos
        if (!isNaN(cantidad) && !isNaN(precio) && !isNaN(ivaProducto)) {
            var totalLineaSinIva = cantidad * precio;
            var totalLineaConIva = totalLineaSinIva * (1 + (ivaProducto / 100));

            // Crear una nueva fila de la tabla con los datos del formulario
            var newRow = `
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck1_${index}">
                            <label class="custom-control-label" for="customCheck1_${index}"><span class="text-hide">Check</span></label>
                            <input type="hidden" name="lineas_pedido[${index}][producto_id]" value="${productoId}">
                        </div>
                    </td>
                    <td>
                        <div class="media align-items-center">
                            <div class="media-body">
                                <span class="js-lists-values-employee-name">${articulo}</span>
                                <input type="hidden" name="lineas_pedido[${index}][articulo]" value="${articulo}">
                            </div>
                        </div>
                    </td>
                    <td align='center'>${referencia}
                        <input type="hidden" name="lineas_pedido[${index}][referencia]" value="${referencia}">
                    </td>
                    <td align='center'>${cantidad}
                        <input type="hidden" name="lineas_pedido[${index}][cantidad]" value="${cantidad}">
                    </td>
                    <td align='center'>${precio.toFixed(2)}€
                        <input type="hidden" name="lineas_pedido[${index}][precio]" value="${precio.toFixed(2)}">
                    </td>
                    <td align='center'>
                        ${comision == "1" ? 'Sí' : 'No'}
                        <input type="hidden" name="lineas_pedido[${index}][comision]" value="${comision}">
                    </td>
                    <td align='center'>${totalLineaSinIva.toFixed(2)}€</td>
                    <td align='center'>${ivaProducto}%
                        <input type="hidden" name="lineas_pedido[${index}][iva_producto]" value="${ivaProducto}">
                    </td>
                    <td align='center'>${totalLineaConIva.toFixed(2)}€</td>
                    <td>
                        <!-- Eliminar fila -->
                        <a href="#" class="text-muted btn-delete">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            `;

            // Insertar la nueva fila antes de la última fila (penúltima posición)
            $('.list tr:last').before(newRow);

            // Calcular y actualizar los totales
            calcularTotales();

            // Incrementar el índice para la próxima línea
            index++;
        } else {
            // Mostrar un mensaje de error o realizar alguna acción
            alert('Por favor, complete todos los campos correctamente antes de añadir un artículo.');
        }
    });

    // Evento para eliminar una fila de la tabla
    $(document).on('click', '.btn-delete', function() {
        // Obtener la fila a la que pertenece el botón de eliminar
        var row = $(this).closest('tr');

        // Obtener el ID de la línea de pedido que se está eliminando
        var lineaPedidoId = row.data('linea-pedido-id');

        // Si la fila no tiene un ID, eliminarla directamente del DOM
        if (!lineaPedidoId) {
            row.remove();
            calcularTotales();
            return; // Salir de la función para evitar la solicitud AJAX
        }

        // Realizar una solicitud AJAX para eliminar la línea de pedido
        $.ajax({
            url: '{{ route("orders.deleteLinea", ":id") }}'.replace(':id', lineaPedidoId),
            type: 'POST',
            data: {
                _method: 'POST',
                _token: "{{ csrf_token() }}",
                id: lineaPedidoId
            },
            success: function(data) {
                if (data.success) {
                    row.remove();
                    calcularTotales();
                } else {
                    alert('Error al eliminar la línea de pedido: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al eliminar la línea de pedido:', error);
                console.log(xhr.responseText);
            }
        });
    });

    // Evento de cambio para el cliente
    $('#cliente').change(function() {
        var clienteId = $(this).val();
        $.ajax({
            url: '{{ route("orders.getDirecciones", ":clienteId") }}'.replace(':clienteId', clienteId),
            type: 'POST',
            data: {
                clienteId: clienteId,
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#destino').empty();
                $.each(data, function(id, direccion) {
                    $('#destino').append($('<option>', {
                        value: id,
                        text: direccion
                    }));
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener direcciones:', error);
                console.log(xhr.responseText);
            }
        });
    });

    // Evento de cambio para el artículo
    $('#articulo').change(function() {
        var articuloId = $(this).find('option:selected').data('articulo-id');
        if (articuloId) {
            $.ajax({
                url: '{{ route("orders.getDatosArticulo", ":articuloId") }}'.replace(':articuloId', articuloId),
                type: 'POST',
                data: {
                    articuloId: articuloId,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    var articuloPrecio = parseFloat(data.precio);
                    if (!isNaN(articuloPrecio)) {
                        $('#precio').val(articuloPrecio);
                        $('#referencia').val(data.referencia);
                    } else {
                        console.error("El precio no es un número válido:", data.precio);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos del artículo:', error);
                    console.log(xhr.responseText);
                }
            });
        } else {
            $('#precio').val('');
        }
    });
});
</script>


               
@endsection


@push('scripts')
   <!-- Select2 -->
   <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
   <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush