
        <!-- Header -->

        <div id="header" class="mdk-header js-mdk-header m-0" data-fixed>
            <div class="mdk-header__content">

                <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-dark  pr-0" id="navbar" data-primary>
                    <div class="container-fluid p-0">

                        <!-- Navbar toggler -->

                        <button class="navbar-toggler navbar-toggler-right d-block d-md-none" type="button" data-toggle="sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>


                        <!-- Navbar Brand -->
                        <a href="/" class="navbar-brand ">
                            <img class="navbar-brand-icon" src="{{ asset('img/CAIMAN_blanco.png') }}" width="50" alt="Stack">
                            <span>Frutas El Caimán</span>
                        </a>




                        <!-- <form class="search-form d-none d-sm-flex flex" action="index.html">
                            <button class="btn" type="submit" role="button"><i class="material-icons">search</i></button>
                            <input type="text" class="form-control" placeholder="Search">
                        </form> -->


                
                        <ul class="nav navbar-nav d-none d-sm-flex border-left navbar-height align-items-center">
                            <li class="nav-item dropdown">
                                <a href="#account_menu" class="nav-link dropdown-toggle" data-toggle="dropdown" data-caret="false">
                                    
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" style='display: inline-block;' />
                                    <span class="ml-1 d-flex-inline">
                                        <span class="text-light">{{ Auth::user()->name }}</span>
                                    </span>
                                </a>
                                <div id="account_menu" class="dropdown-menu dropdown-menu-right">

                                    <a class="dropdown-item" href="{{ ('/') }}">Dashboard</a>
                                    <a class="dropdown-item"  href="{{ route('profile.show') }}">Mi perfil</a>
                                    <div class="dropdown-divider"></div>
                                    <form method="POST" action="{{ route('logout') }}" x-data id='form_logout'>
                                        @csrf
                                     <a class="dropdown-item logout" href="#">Logout</a>
                                    </form>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>

        <!-- // END Header -->