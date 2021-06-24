<!-- MENU SIDEBAR-->
<aside class="menu-sidebar2">
    <div class="logo">
        <a href="#" class="uk-navbar-item uk-logo mx-auto" style="min-height: 75px;">
            <img src="{{asset('assets/imgs/nice_logo.png')}}"  width="100px" alt="NiceTV logo" uk-img>
        </a>
    </div>
    <div class="menu-sidebar2__content js-scrollbar1">
        <div class="account2">
            <h3 class="name">Administrador:</h3>
            <h4 class="name">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h4>
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm">
                    <i class="fa fa-power-off"></i>&nbsp; Cerrar Sesión
                </button>
            </form>
        </div>
        <nav class="navbar-sidebar2">
            @include('plantillas.sidebar_tabs')
        </nav>
    </div>
</aside>
<!-- FIN MENU SIDEBAR-->

@include('plantillas.header_admin')

<!-- MENU MOBILE-->
<aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
    <div class="logo">
        .
    </div>
    <div class="menu-sidebar2__content js-scrollbar2">
        <div class="account2">
            <h3 class="name">Administrador:</h3>
            <h4 class="name">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h4>
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm">
                    <i class="fa fa-power-off"></i>&nbsp; Cerrar Sesión
                </button>
            </form>
        </div>
        <nav class="navbar-sidebar2">
            @include('plantillas.sidebar_tabs')
        </nav>
    </div>
</aside>
<!-- END MENU MOBILE-->
