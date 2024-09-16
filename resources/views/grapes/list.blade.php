@extends('layouts.main')

@section('content')
<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-center">
        <div class="flex flex-edit">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Variedades uva</li>
                </ol>
            </nav>
            <div class='clearfix'></div>
            <h1 class="m-0">Variedades uva</h1>
        </div>
        <a href="{{ route('grapes.ident', ['ident' => Crypt::encrypt(0)]) }}" class="btn btn-success ml-3">Nueva Variedad <i class="material-icons">add</i></a>
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
                        <th>Referencia</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="list" id="staff02">
                    @foreach($uvas as $uva)
                    <tr>
                        <td>
                            <div class="badge badge-light">#{{ $uva->id }}</div>
                        </td>
                        <td>{{ $uva->referencia }}</td>
                        <td>{{ $uva->nombre_articulo }}</td>
                        <td>{{ $uva->precio }} €</td>
                        <td>{{ $uva->stock }}</td>
                        <td><a href="{{ route('grapes.ident', ['ident' => Crypt::encrypt($uva->id)]) }}" class="btn btn-sm btn-link"><i class="material-icons icon-16pt">arrow_forward</i></a></td>
                        <td>  <form id="deleteForm{{ $uva->id }}" method="post" action="{{ route('grapes.delete', ['id' => $uva->id]) }}" style="display: none;">
                            @csrf
                            @method('post')
                        </form>
                        <a href="#" class="text-muted" onclick="event.preventDefault(); document.getElementById('deleteForm{{ $uva->id }}').submit();">
                            <i class="material-icons">delete</i>
                        </a>
                        </a></td>
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
