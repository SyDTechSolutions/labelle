 <nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="/invoices">Facturación</a>
                </li>
                @if(config('app.type') === 'full')
                 <li class="nav-item">
                    <a class="nav-link" href="/proformas">Proformas</a>
                </li>
                @endif
                 @if((auth()->user()->hasRole('admin') || auth()->user()->hasRole('encargado')) && config('app.type') === 'full')
                 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Compras
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                       
                        <a class="dropdown-item" href="/purchases">Facturas de Compras</a>
                        <a class="dropdown-item" href="/productproviders">Comparativa Proveedores</a>
                        <a class="dropdown-item" href="/proformapurchases">Proformas de compras</a>                    
                    </div>
                </li>
               
               
                @endif
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a class="nav-link" href="/receptor/mensajes">Confirmar Docs</a>
                </li>
                @endif
                @if(config('app.type') === 'full')
                <li class="nav-item">
                    <a class="nav-link" href="/cxc">CxC</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cxp">CxP</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="/expenses">Gastos</a>
                </li>
                @endif
               <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reportes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="/reports/invoices/summary">Resumen de Ventas</a>
                        <a class="dropdown-item" href="/reports/invoices">Facturas</a>
                        @if(config('app.type') === 'full')
                        <a class="dropdown-item" href="/reports/facturasProveedor">Facturas Proveedor</a>
                        <a class="dropdown-item" href="/reports/products/sold">Productos Vendidos</a>
                        <a class="dropdown-item" href="/reports/sellers/invoices">Facturas por Vendedor</a>
                        <a class="dropdown-item" href="/reports/customers/invoices">Facturas por Cliente</a>
                        <a class="dropdown-item" href="/reports/cxps/expired">CxP Vencidas</a>
                        <a class="dropdown-item" href="/reports/cxcs/expired">CxC Vencidas</a>
                        <a class="dropdown-item" href="/cxc/Pagadas">CxC Pagadas</a>
                        <a class="dropdown-item" href="/reports/expenses">Gastos</a>
                        @endif
                        <a class="dropdown-item" href="/reports/receptors">Confirmar Documentos</a>
                       
                    </div>
                </li>
                @if(auth()->user()->hasRole('vendedor') && config('app.type') === 'full')
                <li class="nav-item">
                    <a class="nav-link" href="/products">Inventario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/customers">Clientes</a>
                </li>
                @endif
               @if(auth()->user()->hasRole('admin'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Administración
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @can('update', auth()->user())
                        <a class="dropdown-item" href="/settings">Configuracion</a>
                        <a class="dropdown-item" href="/users">Usuarios</a>
                        @if(config('app.type') === 'full')
                        <a class="dropdown-item" href="#" 
                            data-toggle="modal"
                            data-target="#cajaModal">Caja</a>
                        @endif
                        @endcan
                         <a class="dropdown-item" href="/customers">Clientes</a>
                         @if(config('app.type') === 'full')
                          <a class="dropdown-item" href="/providers">Proveedores</a>
                          @endif
                          <a class="dropdown-item" href="/products">Inventario</a>
                          <a class="dropdown-item" href="/taxes">Impuestos</a>
                          @if(config('app.type') === 'full')
                          <a class="dropdown-item" href="/electronicinvoice">Factura de Compra</a>
                          @endif
                           
                    </div>
                </li>
                @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>