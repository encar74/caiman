@extends('layouts.main')

@section('content')
<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-center">
        <div class="flex flex-edit">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Formas de entrega</li>
                </ol>
            </nav>
            <div class='clearfix'></div>
            <h1 class="m-0">Formas de entrega</h1>
        </div>
        <a href="{{ route('delivery.ident', ['ident' => Crypt::encrypt(0)]) }}" class="btn btn-success ml-3">Nueva forma de entrega <i class="material-icons">add</i></a>
    </div>
</div>

<div class="container-fluid page__container">
    <div class="card">
        <div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>

            <div class="search-form search-form--light m-3">
                <input type="text" class="form-control search" placeholder="BUSCAR">
                <button class="btn" type="button" role="button"><i class="material-icons">search</i></button>
            </div>

            <table class="table mb-0 thead-border-top-0 table-striped">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Nombre</th>
                        <th>Método de entrega</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="list" id="staff02">
                @foreach($entregas as $entrega)
                <tr>
                    <td>
                        <div class="badge badge-light">#{{ $entrega->id }}</div>
                    </td>
                    <td>{{ $entrega->nombre }}</td>
                    <td>
                        @if($entrega->icono == 'local_shipping')
                            Vienen a recogerlo <i class="material-icons">directions_run</i>
                        @elseif($entrega->icono == 'directions_run')
                            TIPSA <i class="material-icons">local_shipping</i>
                            @elseif($entrega->icono == 'run_circle')
                            Llevar en mano <i class="material-icons">directions_run</i>
                            @elseif($entrega->icono == '')
                            Otro método <i class="material-icons"></i>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('delivery.ident', ['ident' => Crypt::encrypt($entrega->id)]) }}" class="btn btn-sm btn-link"><i class="material-icons icon-16pt">arrow_forward</i></a>
                    </td>
                    <td>  
                        <form id="deleteForm{{ $entrega->id }}" method="post" action="{{ route('delivery.delete', ['id' => $entrega->id]) }}" style="display: none;">
                            @csrf
                            @method('post')
                        </form>
                        <a href="#" class="text-muted" onclick="event.preventDefault(); document.getElementById('deleteForm{{ $entrega->id }}').submit();">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- List.js -->
    <script src="{{ asset('assets/vendor/list.min.js') }}"></script>
    <script src="{{ asset('assets/js/list.js') }}"></script>
@endpush
