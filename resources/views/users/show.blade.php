@extends('layouts.main')
@push('css')
    <!-- Select2 -->
    <link type="text/css" href="{{ asset('assets/css/vendor-select2.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/vendor-select2.rtl.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/vendor/select2/select2.min.css') }}" rel="stylesheet">

@endpush

@section('content')

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

    <div class="container-fluid page__container">
        <div class="card card-form">
            <div class="row no-gutters">
     
                <div class="col-lg-12 card-form__body card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre">NOMBRE COMERCIAL</label>
                                <input id="nombre" type="text" class="form-control" placeholder="Nombre comercial" value="Frutería Carmen">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="razon_social">Razón social</label>
                                <input id="razon_social" type="text" class="form-control" placeholder="Razón social" value="Frutería Carmen, S.L.">
                            </div>
                        </div>                        

                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="cif">CIF</label>
                                <input id="cif" type="text" class="form-control" placeholder="CIF" value="B123456789">
                            </div>
                        </div>                        
                        <div class="col">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="text" class="form-control" placeholder="Email" value="info@fruteriascarmen.com">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="direccion">Dirección Facturación</label>
                                <input id="direccion" type="text" class="form-control" placeholder="Dirección" value="c/ Alameda,  78">
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="poblacion">Población</label>
                                <input id="poblacion" type="text" class="form-control" placeholder="Población" value="Villena">
                            </div>
                        </div>                        
                        <div class="col">
                            <div class="form-group">
                                <label for="cp">Código Postal</label>
                                <input id="cp" type="text" class="form-control" placeholder="Código Postal" value="03400">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <input id="provincia" type="text" class="form-control" placeholder="Provincia" value="Alicante">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pais">País</label>
                                <input id="pais" type="text" class="form-control" placeholder="País" value="España">
                            </div>
                        </div>

                    </div>                                                        
                                           
                    <div class="form-group">
                        <label for="desc">Notas</label>
                        <textarea id="desc" rows="4" class="form-control" placeholder="notas generales sobre el pedido ..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-3">
                                                       
                        </div>
                        <div class="col-9">
                            <div class=" pull-right">
                                
                                    
                                    <button type="button" class="btn btn-success"> <i class="material-icons mr-1">save</i> Guardar</button>
                                
                            </div>  
                        </div>
                    </div>

        
                </div>
            </div>
        </div>    
        

      


        <div class="card">
            <div class="card-header card-header-large bg-white">
                <h4 class="card-header__title">Direcciones de Envío</h4>
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
                        


                        <tr>

                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck1_1">
                                    <label class="custom-control-label" for="customCheck1_1"><span class="text-hide">Check</span></label>
                                </div>
                            </td>

                            <td>

                                <div class="media align-items-center">
                             
                                    <div class="media-body">

                                        <span class="js-lists-values-employee-name">Oficinas centrales</span>

                                    </div>
                                </div>

                            </td>

                            <td  align='center'>c/Alameda, 77</td>
                            <td  align='center'>Villena</td>
                            <td  align='center'>03400</td>
                            <td  align='center'>Alicante</td>
                            <td  align='center'>España</td>
                           
                            <td><a href="" class="text-muted"><i class="material-icons">delete</i></a></td>
                        </tr>
                        <tr>

                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck1_1">
                                    <label class="custom-control-label" for="customCheck1_1"><span class="text-hide">Check</span></label>
                                </div>
                            </td>

                            <td>

                                <div class="media align-items-center">
                             
                                    <div class="media-body">

                                        <span class="js-lists-values-employee-name">Tienda Elda</span>

                                    </div>
                                </div>

                            </td>

                            <td  align='center'>c/Rios, 5</td>
                            <td  align='center'>Elda</td>
                            <td  align='center'>03600</td>
                            <td  align='center'>Alicante</td>
                            <td  align='center'>España</td>
                           
                            <td><a href="" class="text-muted"><i class="material-icons">delete</i></a></td>
                        </tr>                        

                        




                    </tbody>
                </table>
            </div>

            

            <div class="card-body text-right">
                
            </div>


        </div> 
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
                                <label for="articulo">Identificador dirección</label>
                                <input type="text" class="form-control " id="direccion_1" placeholder="Nombre Dirección" value="" >
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="direccion_1">Dirección</label>
                                <input type="text" class="form-control " id="direccion_1" placeholder="Dirección" value="" >
                            </div>
                        </div>

                                       
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="poblacion">Población</label>
                                <input id="poblacion" type="text" class="form-control" placeholder="Población" value="">
                            </div>
                        </div>                        
                        <div class="col">
                            <div class="form-group">
                                <label for="cp">Código Postal</label>
                                <input id="cp" type="text" class="form-control" placeholder="Código Postal" value="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <input id="provincia" type="text" class="form-control" placeholder="Provincia" value="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pais">País</label>
                                <input id="pais" type="text" class="form-control" placeholder="País" value="">
                            </div>
                        </div>                        
                    </div>                      

                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="button">&nbsp;</label><br>
                                <button type="button" class="btn btn-success">Añadir</button>
                            </div>
                        </div> 
                    </div>

                   
                </div>
            </div>
        </div> 

    </div>
                
@endsection


@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush