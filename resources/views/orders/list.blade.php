@extends('layouts.main')

@section('content')
@include('includes.errors')
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center">
            <div class="flex flex-edit">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                        <li class="breadcrumb-item">Pedidos</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $tipoPedido->nombre }}</li>
                    </ol>
                </nav>
                <div class='clearfix'></div>
                <h1 class="m-0">{{ $tipoPedido->nombre }}</h1>
            </div>
            @if ($tipoPedido->id != 4)
            <a href="{{ route('orders.ident', ['ident' => Crypt::encrypt(0)]) }}" class="btn btn-success ml-3">Nuevo Pedido <i class="material-icons">add</i></a>
            @endif
        </div>
    </div>

    <div class="container-fluid page__container">
        <div class="card card-form d-flex flex-column flex-sm-row">
            <div class="card-form__body card-body-form-group flex">
                <div class="row">
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_name">Nombre</label>
                            <input id="filter_name" type="text" class="form-control" placeholder="Buscar por nombre">
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group" style="width: 200px;">
                            <label for="filter_date">Fecha Pedido</label>
                            <input id="filter_date" type="text" class="form-control" placeholder="Selecciona fecha ..." value="13/03/2023 to 20/03/2023" data-toggle="flatpickr" data-flatpickr-mode="range" data-flatpickr-alt-format="d/m/Y" data-flatpickr-date-format="d/m/Y">
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group" style="width: 200px;">
                            <label for="filter_date_send">Fecha Entrega</label>
                            <input id="filter_date_send" type="text" class="form-control" placeholder="Selecciona fecha ..." value="13/03/2023 to 20/03/2023" data-toggle="flatpickr" data-flatpickr-mode="range" data-flatpickr-alt-format="d/m/Y" data-flatpickr-date-format="d/m/Y">
                        </div>
                    </div>                                    
                </div>
            </div>
            <button class="btn bg-white border-left border-top border-top-sm-0 rounded-top-0 rounded-top-sm rounded-left-sm-0"><i class="material-icons text-primary icon-20pt">refresh</i></button>
        </div>

        <div class="card">
            <div class="table-responsive" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
                <table class="table mb-0 thead-border-top-0 table-striped">
                    <thead>
                        <tr>
                            <th style="width: 18px;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input js-toggle-check-all" data-target="#companies" id="customCheckAll">
                                    <label class="custom-control-label" for="customCheckAll"><span class="text-hide">Toggle all</span></label>
                                </div>
                            </th>
                            <th style="width: 30px;" class="text-center">#ID</th>
                            <th>Cliente</th>
                            <th>Destino</th>
                            <th style="width: 120px;" class="text-center">Fecha</th>
                            <th style="width: 120px;" class="text-center">Fecha Entrega</th>
                            <th style="width: 120px;" class="text-right">Importe total</th>
                            <th style="width: 120px;" class="text-center">Estado</th>
                            <th style="width: 50px;"><a href="#">Detalle</a></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="companies">
                        @foreach ($pedidos as $pedido)
                        <tr>
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck1_{{$loop->index + 1}}">
                                    <label class="custom-control-label" for="customCheck1_{{$loop->index + 1}}"><span class="text-hide">Check</span></label>
                                </div>
                            </td>
                            <td>
                                <div class="badge badge-light">#{{$pedido->id}}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons icon-16pt mr-1 text-primary">business</i>
                                        <a href="{{ route('orders.ident', ['ident' => Crypt::encrypt($pedido->id)]) }}" class="">{{$pedido->cliente->nombre_comercial}}</a>
                                    </div>
                                    @if ($pedido->estado == "NUEVO")
                                    <div class="badge badge-warning ml-2">NUEVO</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="align-items-center">
                                    {{$pedido->direccion->identificador_direccion}}<br>
                                    <small class="text-muted"><i class="material-icons icon-16pt mr-1">pin_drop</i> {{$pedido->ubicacion}}</small>
                                </div>
                            </td>
                            <td style="width: 140px;"><i class="material-icons icon-16pt text-muted-light mr-1">today</i> {{$pedido->fecha}}</td>
                            <td style="width: 140px;"><i class="material-icons icon-16pt text-muted-light mr-1">today</i> {{$pedido->fecha_entrega}}</td>

                            <td class="text-right"><strong>{{$pedido->importe_total}}€</strong></td>
                            <td class="text-center">
                                @if ($pedido->estado == 1)
                                <span class="badge badge-secondary">BORRADOR</span>
                                @elseif ($pedido->estado == 2)
                                <span class="badge badge-warning">PREPARADO</span>
                                @elseif ($pedido->estado == 3)
                                <span class="badge badge-primary">ENVIADO</span>
                                @elseif ($pedido->estado == 4)
                                <span class="badge badge-success">COMPLETADO</span>
                                @endif
                            </td>
                            <td><a href="{{ route('orders.ident', ['ident' => Crypt::encrypt($pedido->id)]) }}" class="btn btn-sm btn-link"><i class="material-icons icon-16pt">arrow_forward</i></a></td>
                            <td><form id="deleteForm{{ $pedido->id }}" method="post" action="{{ route('orders.delete', ['id' => $pedido->id]) }}" style="display: none;">
                            @csrf
                            @method('post')
                        </form>
                        <a href="#" class="text-muted" onclick="event.preventDefault(); document.getElementById('deleteForm{{ $pedido->id }}').submit();">
                            <i class="material-icons">delete</i>
                        </a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body text-right">
            5 <span class="text-muted">of 1,430</span> <a href="#" class="text-muted-light"><i class="material-icons ml-1">arrow_forward</i></a>
        </div>
    </div>
@endsection                    

@push('scripts')
    <!-- List.js -->
    <script src="{{ asset('assets/vendor/list.min.js') }}"></script>
    <script src="{{ asset('assets/js/list.js') }}"></script>
@endpush
