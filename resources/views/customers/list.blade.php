@extends('layouts.main')

@section('content')
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center">
            <div class="flex flex-edit">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Clientes</li>
                    </ol>
                </nav>
                <div class='clearfix'></div>
                <h1 class="m-0">Clientes</h1>
            </div>
            <a href="{{ route('customers.ident', ['ident' => Crypt::encrypt(0)]) }}" class="btn btn-success ml-3">Nuevo Cliente <i class="material-icons">add</i></a>
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
                       
                            <th style="width: 30px;" class="text-center">#ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Contacto</th>
                            <th style="width: 50px;">Detalle</th>
                            <th style="width: 24px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="staff02">
                    @foreach($customers as $customer)
                    <tr>
                                   
                        <td>
                            <div class="badge badge-light">#{{ $customer->id }}</div>
                        </td>                
                        <td>
                            <span class="js-lists-values-employee-name">{{ $customer->nombre_comercial }}</span>
                        </td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->telefono }}</td>
                        <td>{{ $customer->contacto }}</td>
                        <td>
                        <a href="{{ route('customers.ident', ['ident' => Crypt::encrypt($customer->id)]) }}" class="btn btn-sm btn-link">
                            <i class="material-icons icon-16pt">arrow_forward</i>
                        </a>

                        </td>
                        <td>
                        <form id="deleteForm{{ $customer->id }}" method="post" action="{{ route('customers.delete', ['id' => $customer->id]) }}" style="display: none;">
                            @csrf
                            @method('post')
                        </form>
                        <a href="#" class="text-muted" onclick="event.preventDefault(); document.getElementById('deleteForm{{ $customer->id }}').submit();">
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
