<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-center">
        <div class="flex flex-edit">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <?php if(isset($order)): ?>
                        <li class="breadcrumb-item">Pedidos de {{ $order->type->nombre }} </li>
                    <?php endif; ?>
                    <li class="breadcrumb-item active" aria-current="page">Detalle de pedido #29177</li>
                </ol>
            </nav><div class='clearfix'></div>
            <?php if(isset($order)): ?>
                <h1 class="m-0"> Pedido de {{  $order->type->nombre }} </h1>
            <?php endif; ?>
        </div>
        <?php if(isset($order)): ?>
            <a href="{{ route('orders.tipo', ['tipo' => $order->type->ruta ]) }}" class="btn btn-primary ml-3"><i class="material-icons">arrow_back</i> Volver al listado</a>
        <?php endif; ?>
    </div>
</div>
