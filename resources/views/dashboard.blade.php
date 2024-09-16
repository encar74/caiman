@extends('layouts.main')

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Frutas El Caimán</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- Simplebar -->
    <link type="text/css" href="assets/vendor/simplebar.min.css" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="assets/css/app.css" rel="stylesheet">
    <link type="text/css" href="assets/css/app.rtl.css" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="assets/css/vendor-material-icons.css" rel="stylesheet">
    <link type="text/css" href="assets/css/vendor-material-icons.rtl.css" rel="stylesheet">

    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="assets/css/vendor-fontawesome-free.css" rel="stylesheet">
    <link type="text/css" href="assets/css/vendor-fontawesome-free.rtl.css" rel="stylesheet">


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133433427-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-133433427-1');
</script>



    <!-- Flatpickr -->
    <link type="text/css" href="assets/css/vendor-flatpickr.css" rel="stylesheet">
    <link type="text/css" href="assets/css/vendor-flatpickr.rtl.css" rel="stylesheet">
    <link type="text/css" href="assets/css/vendor-flatpickr-airbnb.css" rel="stylesheet">
    <link type="text/css" href="assets/css/vendor-flatpickr-airbnb.rtl.css" rel="stylesheet">




</head>

<body class="layout-default">

    <div class="preloader"></div>

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">

        <!-- Header -->

       

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">

            <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
                <div class="mdk-drawer-layout__content page">



                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex align-items-center">
                            <div class="flex">

                                <h1 class="m-0"></h1>
                            </div>
                            
                        </div>
                    </div>

                    <div style="max-width:80%; margin-right:0; " class="container-fluid page__container">


                    <div class="card col-11 col-md-11">
    <div class="card-header bg-white d-flex align-items-center">
        <h4 class="card-header__title mb-0"><span id="totalYear" class="ml-2">Ganancias total año: € 0.00</span></h4>
        <div class="flatpickr-wrapper flatpickr-calendar-right d-flex ml-auto">
            <div>
                <form class="form-inline">
                    <label class="mr-sm-2" for="selectProductType">Tipo de Producto:</label>
                    <select id="selectProductType" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                        <option value="2">Mermeladas/Conservas</option>
                        <option value="1">Campaña</option>
                        <option value="3">Nochevieja</option>
                    </select>

                    <label class="mr-sm-2" for="selectYear">Año:</label>
                    <select id="selectYear" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                        <!-- Opciones de años -->
                        @for ($year = date('Y'); $year >= 2024; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="earningsChart" class="chart-canvas"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productTypeSelect = document.getElementById('selectProductType');
    const yearSelect = document.getElementById('selectYear');
    const totalYear = document.getElementById('totalYear');

    const productos = @json($productos);
    const pedidos = @json($pedidos);
    const lineas = @json($lineas);

    const ctx = document.getElementById('earningsChart').getContext('2d');
    const earningsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Euros recaudados',
                data: [], // Se llenará dinámicamente
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            // Formato de tooltip en euros con dos decimales y símbolo de euro
                            const value = context.raw;
                            return '€ ' + value.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            // Formato del eje Y en euros con dos decimales y símbolo de euro
                            return '€ ' + value.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    function parseDate(dateString) {
        const [day, month, year] = dateString.split('/').map(Number);
        return new Date(year, month - 1, day);
    }

    function updateChart() {
        const selectedProductType = parseInt(productTypeSelect.value);
        const selectedYear = parseInt(yearSelect.value);

        const monthlyData = Array(12).fill(0);
        let totalEuros = 0;

        lineas.forEach(linea => {
            const pedido = pedidos.find(p => p.id === linea.pedidos_id);
            const producto = productos.find(p => p.id === linea.articulo_id);

            if (pedido && producto && producto.tipo_producto === selectedProductType) {
                const pedidoDate = parseDate(pedido.fecha);
                const isSameYear = pedidoDate.getFullYear() === selectedYear;

                if (isSameYear) {
                    const precio = parseFloat(linea.precio);
                    const iva = parseFloat(producto.iva);
                    const euros = parseInt(linea.cantidad) * precio * (1 + iva / 100);

                    monthlyData[pedidoDate.getMonth()] += euros;
                    totalEuros += euros;
                }
            }
        });

        earningsChart.data.datasets[0].data = monthlyData;
        earningsChart.update();

        // Actualiza el total del año mostrado
        totalYear.textContent = 'Ganancias totales : ' + totalEuros.toFixed(2) + ' €';
    }

    productTypeSelect.addEventListener('change', updateChart);
    yearSelect.addEventListener('change', updateChart);

    updateChart(); // Inicializa el gráfico
});
</script>










                        
                <div class="card col-11 col-md-11">
                <div class="card-header">
                    <form class="form-inline">
                        <label class="mr-sm-2" for="inlineFormRole">TOTAL DE:</label>
                        <select id="inlineFormRole" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                            <option value="Unidades">Unidades</option>
                            <option value="Euros">Euros</option>
                        </select>

                        <label class="mr-sm-2" for="inlineFormRole2">VENTAS DE:</label>
                        <select id="inlineFormRole2" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                            <option value="todas">Todas las Mermeladas y conservas</option>
                            @foreach ($productos as $productoId => $producto)
                            @if ($producto['tipo_producto'] == '2')
                                <option value="{{ $productoId +1 }}" data-articulo-id="{{ $producto['id'] }}" data-iva="{{ $producto['iva'] }}">{{ $producto['nombre_articulo'] }}</option>
                            @endif        
                            @endforeach
                        </select>

                        <label class="mr-sm-2" for="inlineFormPeriod">EN:</label>
                        <select id="inlineFormPeriod" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                            <option value="resumen_anual">Resumen año</option>
                            <option value="enero">Enero</option>
                            <option value="febrero">Febrero</option>
                            <option value="marzo">Marzo</option>
                            <option value="abril">Abril</option>
                            <option value="mayo">Mayo</option>
                            <option value="junio">Junio</option>
                            <option value="julio">Julio</option>
                            <option value="agosto">Agosto</option>
                            <option value="septiembre">Septiembre</option>
                            <option value="octubre">Octubre</option>
                            <option value="noviembre">Noviembre</option>
                            <option value="diciembre">Diciembre</option>
                        </select>

                        <label class="mr-sm-2" for="inlineFormYear">AÑO:</label>
                        <select id="inlineFormYear" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                            @for ($year = date('Y'); $year >= 2024; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>

                    </form>
                </div>

    <div class="table-responsive border-bottom">
        <table class="table mb-0 thead-border-top-0">
            <thead>
                <tr>
                    <th style="width: 50%;">Producto</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
                <!-- Las filas se agregarán dinámicamente con JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('inlineFormRole2'); 
    const totalSelect = document.getElementById('inlineFormRole'); 
    const periodSelect = document.getElementById('inlineFormPeriod'); 
    const yearSelect = document.getElementById('inlineFormYear'); 
    const tableBody = document.getElementById('productTableBody');

    const data = @json($productos);
    const pedidos = @json($pedidos);
    const lineas = @json($lineas);

    function parseDate(dateString) {
        const [day, month, year] = dateString.split('/').map(Number);
        return new Date(year, month - 1, day);
    }

    function getFilteredData() {
        const selectedProductId = productSelect.value;
        const selectedMonth = periodSelect.value;
        const selectedYear = yearSelect.value;
        
        let filteredData = {};

        // Inicializar todos los productos con totalUnidades y totalEuros en 0
        data.forEach(producto => {
            if (producto['tipo_producto'] == '2' && (selectedProductId === 'todas' || selectedProductId == producto.id)) {
                filteredData[producto.id] = {
                    nombre: producto.nombre_articulo,
                    totalUnidades: 0,
                    totalEuros: 0
                };
            }
        });

        // Actualizar los datos con las líneas de pedido
        lineas.forEach(linea => {
            const pedido = pedidos.find(p => p.id === linea.pedidos_id);
            const producto = data.find(p => p.id === linea.articulo_id);
            
            if (pedido && producto && filteredData[producto.id]) {
                const pedidoDate = parseDate(pedido.fecha);
                
                const isSameMonth = selectedMonth === 'resumen_anual' || (pedidoDate.getMonth() === periodSelect.selectedIndex - 1);
                const isSameYear = pedidoDate.getFullYear() == selectedYear;

                if (isSameMonth && isSameYear) {
                    const cantidad = parseInt(linea.cantidad, 10);
                    const precio = parseFloat(linea.precio);
                    const iva = parseFloat(producto.iva);

                    filteredData[producto.id].totalUnidades += cantidad;
                    filteredData[producto.id].totalEuros += cantidad * precio * (1 + iva / 100);
                }
            }
        });

        return filteredData;
    }

    function updateTable() {
        const filteredData = getFilteredData();
        const totalType = totalSelect.value;
        
        tableBody.innerHTML = '';

        Object.values(filteredData).forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.nombre}</td>
                <td>${totalType === 'Unidades' ? item.totalUnidades + ' uds.' : item.totalEuros.toFixed(2) + ' €'}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    productSelect.addEventListener('change', updateTable);
    totalSelect.addEventListener('change', updateTable);
    periodSelect.addEventListener('change', updateTable);
    yearSelect.addEventListener('change', updateTable);

    updateTable();
});



</script>





<div class="card col-11 col-md-11">
    <div class="card-header">
        <form class="form-inline">
            <label class="mr-sm-2" for="inlineFormRoleCampana">TOTAL DE:</label>
            <select id="inlineFormRoleCampana" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                <option value="Kg">Kg</option>
                <option value="Euros">Euros</option>
            </select>

            <label class="mr-sm-2" for="inlineFormRole2Campana">VENTAS DE:</label>
            <select id="inlineFormRole2Campana" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                <option value="todas_campana">Todas campaña</option>
                <option value="todas_noche_vieja">Todas Nochevieja</option>
                @foreach ($productos as $productoId => $producto)
                @if ($producto['tipo_producto'] == '3')
                    <option value="{{ $productoId +1 }}" data-articulo-id="{{ $producto['id'] }}" data-iva="{{ $producto['iva'] }}">{{ $producto['nombre_articulo'] }}</option>
                @endif        
                @endforeach
            </select>

            <label class="mr-sm-2" for="inlineFormPeriodCampana">EN:</label>
            <select id="inlineFormPeriodCampana" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                <option value="resumen_anual">Resumen año</option>
                <option value="enero">Enero</option>
                <option value="febrero">Febrero</option>
                <option value="marzo">Marzo</option>
                <option value="abril">Abril</option>
                <option value="mayo">Mayo</option>
                <option value="junio">Junio</option>
                <option value="julio">Julio</option>
                <option value="agosto">Agosto</option>
                <option value="septiembre">Septiembre</option>
                <option value="octubre">Octubre</option>
                <option value="noviembre">Noviembre</option>
                <option value="diciembre">Diciembre</option>
            </select>

            <label class="mr-sm-2" for="inlineFormYearCampana">AÑO:</label>
            <select id="inlineFormYearCampana" class="custom-select mb-2 mr-sm-2 mb-sm-0">
                @for ($year = date('Y'); $year >= 2024; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </form>
    </div>

    <div class="table-responsive border-bottom">
        <table class="table mb-0 thead-border-top-0">
            <thead>
                <tr>
                    <th style="width:50%;">Producto</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="productTableBodyCampana">
                <!-- Las filas se agregarán dinámicamente con JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelectCampana = document.getElementById('inlineFormRole2Campana'); 
    const totalSelectCampana = document.getElementById('inlineFormRoleCampana'); 
    const periodSelectCampana = document.getElementById('inlineFormPeriodCampana'); 
    const yearSelectCampana = document.getElementById('inlineFormYearCampana'); 
    const tableBodyCampana = document.getElementById('productTableBodyCampana');

    const dataCampana = @json($productos);
    const pedidosCampana = @json($pedidos);
    const lineasCampana = @json($lineas);

    function parseDateCampana(dateString) {
        const [day, month, year] = dateString.split('/').map(Number);
        return new Date(year, month - 1, day);
    }

    function convertToKg(weightString) {
        const lowerCaseWeightString = weightString.toLowerCase();
        if (lowerCaseWeightString.endsWith('kg')) {
            return parseFloat(weightString) * 1000; // Convertir a gramos
        } else if (lowerCaseWeightString.endsWith('g')) {
            return parseFloat(weightString); // Ya está en gramos
        } else {
            console.warn(`Formato de peso no reconocido: ${weightString}`);
            return 0; // Si el formato no es reconocible
        }
    }

    function getFilteredDataCampana() {
        const selectedProductId = productSelectCampana.value;
        const selectedMonth = periodSelectCampana.value;
        const selectedYear = yearSelectCampana.value;
        
        let filteredData = {};

        // Filtrar productos según la selección
        dataCampana.forEach(producto => {
            const isCampaign = selectedProductId === 'todas_campana' && producto.tipo_producto == '1';
            const isNocheVieja = selectedProductId === 'todas_noche_vieja' && producto.tipo_producto == '3';
            const isSpecificProduct = selectedProductId == producto.id;

            if (isCampaign || isNocheVieja || isSpecificProduct) {
                filteredData[producto.id] = {
                    nombre: producto.nombre_articulo,
                    totalKg: 0,
                    totalEuros: 0
                };
            }
        });

        // Actualizar los datos con las líneas de pedido
        lineasCampana.forEach(linea => {
            const pedido = pedidosCampana.find(p => p.id === linea.pedidos_id);
            const producto = dataCampana.find(p => p.id === linea.articulo_id);
            
            if (pedido && producto && filteredData[producto.id]) {
                const pedidoDate = parseDateCampana(pedido.fecha);
                
                const isSameMonth = selectedMonth === 'resumen_anual' || (pedidoDate.getMonth() === periodSelectCampana.selectedIndex - 1);
                const isSameYear = pedidoDate.getFullYear() == selectedYear;

                if (isSameMonth && isSameYear) {
                    const cantidad = parseInt(linea.cantidad, 10);
                    const precio = parseFloat(linea.precio);
                    const iva = parseFloat(producto.iva);
                    const kgEnGramos = convertToKg(producto.kg_caja) * cantidad;

                    filteredData[producto.id].totalKg += kgEnGramos;
                    filteredData[producto.id].totalEuros += cantidad * precio * (1 + iva / 100);
                }
            }
        });

        return filteredData;
    }

    function updateTableCampana() {
        const filteredData = getFilteredDataCampana();
        const totalType = totalSelectCampana.value;
        
        tableBodyCampana.innerHTML = '';

        Object.values(filteredData).forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.nombre}</td>
                <td>${totalType === 'Kg' ? (item.totalKg / 1000).toFixed(2) + ' kg' : item.totalEuros.toFixed(2) + ' €'}</td>
            `;
            tableBodyCampana.appendChild(row);
        });
    }

    productSelectCampana.addEventListener('change', updateTableCampana);
    totalSelectCampana.addEventListener('change', updateTableCampana);
    periodSelectCampana.addEventListener('change', updateTableCampana);
    yearSelectCampana.addEventListener('change', updateTableCampana);

    updateTableCampana();
});
</script>










    <div class="card col-11 col-md-11">
        <div class="card-header">
            <form class="form-inline">
                <label class="mr-sm-2" for="lotNumber">Número de Lote:</label>
                <input type="text" id="lotNumber" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Número de Lote">
                <button type="button" id="searchButton" class="btn btn-primary mb-2">Buscar</button>
            </form>
        </div>

        <div class="table-responsive border-bottom">
            <table class="table mb-0 thead-border-top-0">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    <!-- Las filas se agregarán dinámicamente con JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchButton = document.getElementById('searchButton');
    const lotNumberInput = document.getElementById('lotNumber');
    const tableBody = document.getElementById('ordersTableBody');

    const dataLineas = @json($lineas);
    const dataPedidos = @json($pedidos);
    const dataClientes = @json($clientes);

    function getOrdersByLotNumber(lotNumber) {
        let orders = {};

        // Filtrar las líneas por número de lote
        dataLineas.forEach(linea => {
            // Asegurarse de que lote es una cadena
            const lote = String(linea.lote).trim();

            if (lote === lotNumber.trim()) {
                const pedido = dataPedidos.find(p => p.id === linea.pedidos_id);
                if (pedido) {
                    const cliente = dataClientes.find(c => c.id === pedido.id_cliente);
                    if (cliente) {
                        if (!orders[pedido.id]) {
                            orders[pedido.id] = {
                                nombreCliente: cliente.nombre_comercial,
                                idPedido: pedido.id
                            };
                        }
                    }
                }
            }
        });

        return orders;
    }

    function updateTable() {
        const lotNumber = lotNumberInput.value.trim();
        console.log('Buscando lote:', lotNumber); // Debugging line
        const orders = getOrdersByLotNumber(lotNumber);
        
        console.log('Órdenes encontradas:', orders); // Debugging line
        tableBody.innerHTML = '';

        Object.values(orders).forEach(order => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${order.nombreCliente}</td>
                <td>
                    <a href="{{ url('orders/detail') }}/${order.idPedido}/generar-pdf" class="btn btn-light" target='_blank'>
                        <i class="material-icons mr-1">send</i> Generar Albarán
                    </a>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    searchButton.addEventListener('click', updateTable);
});
</script>





                <!-- // END drawer-layout__content -->

                <div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
                    <div class="mdk-drawer__content">
                        <div class="sidebar sidebar-light sidebar-left simplebar" data-simplebar>
                            <div class="d-flex align-items-center sidebar-p-a border-bottom sidebar-account">
                                <a href="profile.html" class="flex d-flex align-items-center text-underline-0 text-body">
                                    <span class="avatar mr-3">
                                        <img src="assets/images/avatar/demi.png" alt="avatar" class="avatar-img rounded-circle">
                                    </span>
                                    <span class="flex d-flex flex-column">
                                        <strong>Adrian Demian</strong>
                                        <small class="text-muted text-uppercase">Account Manager</small>
                                    </span>
                                </a>
                                <div class="dropdown ml-auto">
                                    <a href="#" data-toggle="dropdown" data-caret="false" class="text-muted"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-item-text dropdown-item-text--lh">
                                            <div><strong>Adrian Demian</strong></div>
                                            <div>@adriandemian</div>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="index.html">Dashboard</a>
                                        <a class="dropdown-item" href="profile.html">My profile</a>
                                        <a class="dropdown-item" href="edit-account.html">Edit account</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="login.html">Logout</a>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar-heading sidebar-m-t">Menu</div>
                            <ul class="sidebar-menu">
                                <li class="sidebar-menu-item active open">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#dashboards_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dvr</i>
                                        <span class="sidebar-menu-text">Dashboards</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse show " id="dashboards_menu">
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="index.html">
                                                <span class="sidebar-menu-text">Default</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="dashboard-quick-access.html">
                                                <span class="sidebar-menu-text">Quick Access</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item active">
                                            <a class="sidebar-menu-button" href="staff.html">
                                                <span class="sidebar-menu-text">CRM/Staff</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="analytics.html">
                                                <span class="sidebar-menu-text">E-commerce</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#apps_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">slideshow</i>
                                        <span class="sidebar-menu-text">Apps</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="apps_menu">
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="app-trello.html">
                                                <span class="sidebar-menu-text">Trello</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="app-projects.html">
                                                <span class="sidebar-menu-text">Projects</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="app-fullcalendar.html">
                                                <span class="sidebar-menu-text">Event Calendar</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="app-chat.html">
                                                <span class="sidebar-menu-text">Chat</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="app-email.html">
                                                <span class="sidebar-menu-text">Email</span>
                                                <span class="badge badge-primary ml-auto">NEW</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item ">
                                            <a class="sidebar-menu-button" data-toggle="collapse" href="#course_menu">
                                                <span class="sidebar-menu-text">Education</span>
                                                <span class="ml-auto d-flex align-items-center">
                                                    <span class="sidebar-menu-toggle-icon"></span>
                                                </span>
                                            </a>
                                            <ul class="sidebar-submenu collapse " id="course_menu">
                                                <li class="sidebar-menu-item ">
                                                    <a class="sidebar-menu-button" href="app-course.html">
                                                        <span class="sidebar-menu-text">Course</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-menu-item ">
                                                    <a class="sidebar-menu-button" href="app-lesson.html">
                                                        <span class="sidebar-menu-text">Lesson</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#pages_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">description</i>
                                        <span class="sidebar-menu-text">Pages</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="pages_menu">
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="companies.html">
                                                <span class="sidebar-menu-text">Companies</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="stories.html">
                                                <span class="sidebar-menu-text">Stories</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="discussions.html">
                                                <span class="sidebar-menu-text">Discussions</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="payout.html">
                                                <span class="sidebar-menu-text">Payout</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="invoice.html">
                                                <span class="sidebar-menu-text">Invoice</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="pricing.html">
                                                <span class="sidebar-menu-text">Pricing</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="edit-account.html">
                                                <span class="sidebar-menu-text">Edit Account</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="profile.html">
                                                <span class="sidebar-menu-text">User Profile</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="digital-product.html">
                                                <span class="sidebar-menu-text">Digital Product</span>
                                                <span class="badge badge-primary ml-auto">NEW</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" data-toggle="collapse" href="#login_menu">
                                                <span class="sidebar-menu-text">Login</span>
                                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                            </a>
                                            <ul class="sidebar-submenu collapse" id="login_menu">
                                                <li class="sidebar-menu-item">
                                                    <a class="sidebar-menu-button" href="login.html">
                                                        <span class="sidebar-menu-text">Login / Background Image</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-menu-item">
                                                    <a class="sidebar-menu-button" href="login-centered-boxed.html">
                                                        <span class="sidebar-menu-text">Login / Centered Boxed</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" data-toggle="collapse" href="#signup_menu">
                                                <span class="sidebar-menu-text">Sign Up</span>
                                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                            </a>
                                            <ul class="sidebar-submenu collapse" id="signup_menu">
                                                <li class="sidebar-menu-item">
                                                    <a class="sidebar-menu-button" href="signup.html">
                                                        <span class="sidebar-menu-text">Sign Up / Background Image</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-menu-item">
                                                    <a class="sidebar-menu-button" href="signup-centered-boxed.html">
                                                        <span class="sidebar-menu-text">Sign Up / Centered Boxed</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#layouts_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">view_compact</i>
                                        <span class="sidebar-menu-text">Layouts</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="layouts_menu">
                                        <li class="sidebar-menu-item active">
                                            <a class="sidebar-menu-button" href="staff.html">
                                                <span class="sidebar-menu-text">Default</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="fluid-staff.html">
                                                <span class="sidebar-menu-text">Full Width Navs</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="fixed-staff.html">
                                                <span class="sidebar-menu-text">Fixed Navs</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="mini-staff.html">
                                                <span class="sidebar-menu-text">Mini Sidebar + Navs</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="sidebar-heading">UI Components</div>
                            <div class="sidebar-block p-0">
                                <ul class="sidebar-menu" id="components_menu">
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-buttons.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">mouse</i>
                                            <span class="sidebar-menu-text">Buttons</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-alerts.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">notifications</i>
                                            <span class="sidebar-menu-text">Alerts</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-avatars.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">person</i>
                                            <span class="sidebar-menu-text">Avatars</span>
                                            <span class="badge badge-primary ml-auto">NEW</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-modals.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">aspect_ratio</i>
                                            <span class="sidebar-menu-text">Modals</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-charts.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">pie_chart_outlined</i>
                                            <span class="sidebar-menu-text">Charts</span>
                                            <span class="badge badge-warning ml-auto">PRO</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-icons.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">brush</i>
                                            <span class="sidebar-menu-text">Icons</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-forms.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">text_format</i>
                                            <span class="sidebar-menu-text">Forms</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-range-sliders.html">
                                            <!-- tune or low_priority or linear_scale or space_bar or swap_calls -->
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">tune</i>
                                            <span class="sidebar-menu-text">Range Sliders</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-datetime.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">event_available</i>
                                            <span class="sidebar-menu-text">Time &amp; Date</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-tables.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dns</i>
                                            <span class="sidebar-menu-text">Tables</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-tabs.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">tab</i>
                                            <span class="sidebar-menu-text">Tabs</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-loaders.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">refresh</i>
                                            <span class="sidebar-menu-text">Loaders</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-drag.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">control_point</i>
                                            <span class="sidebar-menu-text">Drag &amp; Drop</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-pagination.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">last_page</i>
                                            <span class="sidebar-menu-text">Pagination</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="ui-vector-maps.html">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">location_on</i>
                                            <span class="sidebar-menu-text">Vector Maps</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="sidebar-p-a sidebar-b-y">
                                    <div class="d-flex align-items-top mb-2">
                                        <div class="sidebar-heading m-0 p-0 flex text-body js-text-body">Progress</div>
                                        <div class="font-weight-bold text-success">60%</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="sidebar-p-a">
                                <a href="https://themeforest.net/item/stack-admin-bootstrap-4-dashboard-template/22959011" class="btn btn-outline-primary btn-block">Purchase Stack &dollar;35</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- // END drawer-layout -->

        </div>
        <!-- // END header-layout__content -->

    </div>
    <!-- // END header-layout -->

    <!-- App Settings FAB -->
    <div id="app-settings">
        <app-settings layout-active="default" :layout-location="{
      'default': 'staff.html',
      'fixed': 'fixed-staff.html',
      'fluid': 'fluid-staff.html',
      'mini': 'mini-staff.html'
    }"></app-settings>
    </div>

    <!-- jQuery -->
    <script src="assets/vendor/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/vendor/popper.min.js"></script>
    <script src="assets/vendor/bootstrap.min.js"></script>

    <!-- Simplebar -->
    <script src="assets/vendor/simplebar.min.js"></script>

    <!-- DOM Factory -->
    <script src="assets/vendor/dom-factory.js"></script>

    <!-- MDK -->
    <script src="assets/vendor/material-design-kit.js"></script>

    <!-- App -->
    <script src="assets/js/toggle-check-all.js"></script>
    <script src="assets/js/check-selected-row.js"></script>
    <script src="assets/js/dropdown.js"></script>
    <script src="assets/js/sidebar-mini.js"></script>
    <script src="assets/js/app.js"></script>

    <!-- App Settings (safe to remove) -->
    <script src="assets/js/app-settings.js"></script>



    <!-- Flatpickr -->
    <script src="assets/vendor/flatpickr/flatpickr.min.js"></script>
    <script src="assets/js/flatpickr.js"></script>

    <!-- Global Settings -->
    <script src="assets/js/settings.js"></script>


    <!-- Chart.js -->
    <script src="assets/vendor/Chart.min.js"></script>

    <!-- UI Charts Page JS -->
    <script src="assets/js/chartjs-rounded-bar.js"></script>
    <script src="assets/js/charts.js"></script>

    <!-- Chart.js Samples -->
    <script src="assets/js/page.staff.js"></script>

</body>

</html>

@section('content')
@endsection