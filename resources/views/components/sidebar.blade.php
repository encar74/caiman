<div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
                    <div class="mdk-drawer__content">
                        <div class="sidebar sidebar-light sidebar-left simplebar" data-simplebar>
                            <div class="d-flex align-items-center sidebar-p-a border-bottom sidebar-account">
                                <a href="{{ route('profile.show') }}" class="flex d-flex align-items-center text-underline-0 text-body">
                                    <span class="avatar mr-3">
                                        
                                        <img class="h-12 w-12 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </span>
                                    <span class="flex d-flex flex-column">
                                        <strong>{{ Auth::user()->name }}</strong>
                                       <!-- <small class="text-muted text-uppercase">Account Manager</small>-->
                                    </span>
                                </a>
                                <div class="dropdown ml-auto">
                                    <a href="#" data-toggle="dropdown" data-caret="false" class="text-muted"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                    <a class="dropdown-item"  href="{{ route('profile.show') }}">Mi perfil</a>
                                    <div class="dropdown-divider"></div>
                                   
                                     <a class="dropdown-item logout" href="#" >Cerrar sesión</a>
                                   
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar-heading sidebar-m-t"></div>
                            <ul class="sidebar-menu">
                                @php
                                    $menu_activo = " ";
                                  
                                    if(session()->has('section')   &&   session()->get('section') == 'order')   
                                        $menu_activo = " active open ";
                                @endphp
                                <li class="sidebar-menu-item {{ $menu_activo }}">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#pedidos_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">business_center</i>
                                        <span class="sidebar-menu-text">Pedidos</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>

                                    <ul class="sidebar-submenu collapse  " id="pedidos_menu">
                                        @foreach ($menus_pedido as $tipo)
                                            @php
                                            $menu_activo = "";
                                        
                                            if(session()->has('subsection') &&   session()->get('subsection') ==  $tipo->id)   
                                                $menu_activo = " active ";
                                            @endphp                                        
                                        <li class="sidebar-menu-item {{ $menu_activo }}">
                                            <a class="sidebar-menu-button" href="{{ route('orders.tipo', ['tipo' => $tipo->url ]) }}">
                                                <span class="sidebar-menu-text">{{ $tipo->nombre }}</span>
                                            </a>
                                        </li>
                                        @endforeach
                                        <li class="sidebar-menu-item {{ $menu_activo }}">
                                        <a class="sidebar-menu-button" href="{{ route('orders.tipo', ['tipo' => 'todos']) }}">
                                            <span class="sidebar-menu-text">Todos los pedidos</span>
                                        </a>
                                    </li>

                                   
                                    </ul>
                                </li>

                                @php
                                    $menu_activo = " ";
                                  
                                    if(session()->has('section')   &&   session()->get('section') == 'customer')   
                                        $menu_activo = " active open ";
                                @endphp

                                <li class="sidebar-menu-item {{ $menu_activo }}">
                                    <a class="sidebar-menu-button" href="{{ route('customers') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">person</i>
                                        <span class="sidebar-menu-text">Clientes</span>
                                    </a>
                                </li>    


                                @php
                                    $menu_activo = " ";
                                  
                                    if(session()->has('section')   &&   session()->get('section') == 'product')   
                                        $menu_activo = " active open ";
                                @endphp
                                <li class="sidebar-menu-item {{ $menu_activo }}">
                                    <a class="sidebar-menu-button" href="{{ route('products') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-box-open"></i>
                                        <span class="sidebar-menu-text">Productos</span>
                                    </a>
                                </li>  

                                @php
                                $menu_activo = " ";
                              
                                if(session()->has('section')   &&   session()->get('section') == 'grape')   
                                    $menu_activo = " active open ";
                                @endphp

                                <li class="sidebar-menu-item {{ $menu_activo }}">
                                    <a class="sidebar-menu-button" href="{{ route('grapes') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left"><svg id="uva" height="24" viewBox="0 0 66 66" width="24" xmlns="http://www.w3.org/2000/svg"><g><path d="m17.4 63.1c.8-.8 1.4-1.8 1.7-2.8 2.6 2.5 6.7 2.4 9.2-.1.8-.8 1.3-1.7 1.6-2.7 2.6 2.5 6.7 2.4 9.2-.2 2.5-2.5 2.6-6.6.2-9.2 1-.3 1.9-.9 2.7-1.6 2.6-2.6 2.6-6.8 0-9.4-1-1-2.3-1.6-3.6-1.9 6.8-4.2 15.4-5.5 19.1-5.9 1.7-.2 2.8-1.9 2.1-3.5l-1.6-4.5c-.3-.7-.8-1.2-1.5-1.5-2.3-.8-5.1.1-8 1.9-.1-2.5-.7-6.9-3.5-10.2-6-6.9-16-1.9-23-10.1-.2-.4-.7-.5-1-.4-.4.1-.7.5-.7.9-.1.5-1.3 13.4 5.1 20.6 4.5 4.9 10.8 5.3 17.3 3.6-2.4 2.2-4.7 4.6-6.7 6.9-.2-1.4-.8-2.8-1.9-3.9-2.6-2.6-6.8-2.6-9.4 0-.8.8-1.3 1.7-1.6 2.7-1.2-1.1-2.8-1.8-4.5-1.8-5.8 0-8.8 6.9-4.9 11.2-1 .3-2 .9-2.7 1.7-2.5 2.5-2.6 6.6-.1 9.2-1 .3-2 .9-2.8 1.7-2.6 2.6-2.6 6.8 0 9.4 2.5 2.4 6.7 2.4 9.3-.1zm9.5-42c-4.4-4.8-4.8-13-4.7-16.9 9.2 7.5 16.2 2.7 21.2 8.6 2.9 3.4 3.1 8.3 3.1 10-6.9 2.6-14.7 3.8-19.6-1.7zm0 37.6c-1.8 1.8-4.7 1.8-6.6 0-1.8-1.8-1.8-4.8 0-6.6s4.8-1.8 6.6 0c1.6 1.7 2 4.7 0 6.6zm-3.7-17.4c1.8-1.8 4.8-1.8 6.6 0s1.8 4.7 0 6.6c-1.9 1.9-4.8 1.7-6.6 0-1.7-1.8-1.8-4.8 0-6.6zm14.6 14.5c-1.8 1.8-4.7 1.8-6.6 0-1.7-1.7-1.9-4.7 0-6.6 1.8-1.8 4.8-1.8 6.6 0 1.8 1.9 1.8 4.8 0 6.6zm2.9-10.8c-2.4 2.4-6.5 1.5-7.6-1.7-.3-1.7-.5-3.2 1.1-4.8 1.8-1.8 4.7-1.8 6.6 0 1.7 1.7 1.7 4.7-.1 6.5zm13.8-23.5c.5 0 1.4.1 1.6.5l1.7 4.5c.1.4-.1.7-.5.8-3.6.4-11.4 1.5-18.3 5.2 6.6-7.1 12.1-11 15.5-11zm-28.4 8.9c1.8-1.8 4.7-1.8 6.6 0 1.8 1.8 1.8 4.8 0 6.6-2 2-5 1.6-6.6 0-1.7-1.8-1.8-4.7 0-6.6zm-7.6 1.6c4.2 0 6.1 5.1 3.3 7.9-1.8 1.8-4.8 1.8-6.6 0-2.8-2.9-.8-7.9 3.3-7.9zm-6.1 12.2c2-2 5-1.6 6.6 0 .9.9 1.1 1.8 1.3 2.4.5 2.9-1.7 5.5-4.6 5.5-4.2 0-6.2-5-3.3-7.9zm-2.9 10.9c1.8-1.8 4.7-1.8 6.6 0 1.8 1.8 1.8 4.8 0 6.6s-4.7 1.8-6.6 0c-1.9-1.9-1.9-4.8 0-6.6z"/><path d="m34.2 15c-3.9-.1-7.2-5.4-7.2-5.4-.3-.5-.9-.6-1.4-.3s-.6.9-.3 1.4c.2.3 3.9 6.3 8.9 6.4 4.4.1 7.8 3.3 7.8 3.4.4.4 1 .4 1.4 0s.4-1 0-1.4c-.2-.3-3.9-4-9.2-4.1z"/></g></svg></i>
                                        <span class="sidebar-menu-text">Variedades Uva</span>
                                        
                                    </a>
                                </li>                                  

                            

                                @php
                                $menu_activo = " ";
                              
                                if(session()->has('section')   &&   session()->get('section') == 'delivery')   
                                    $menu_activo = " active open ";
                                @endphp

                                <li class="sidebar-menu-item {{ $menu_activo }}">
                                    <a class="sidebar-menu-button" href="{{ route('delivery') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left">
                                            <i class="material-icons">local_shipping</i>
                                        </i>
                                        <span class="sidebar-menu-text">Formas Entrega</span>
                                    </a>
                                </li>




                    
                               
                            </ul>
                       

                        </div>
                    </div>
                </div>