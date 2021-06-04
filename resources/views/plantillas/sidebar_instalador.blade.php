<!-- MENU SIDEBAR-->
<aside class="menu-sidebar2" onload="pintarTab(1)">
    <div class="logo">
        <a href="#" class="uk-navbar-item uk-logo mx-auto" style="min-height: 75px;">
            <img src="{{asset('assets/imgs/nice_logo.png')}}"  width="100px" alt="NiceTV logo" uk-img>
        </a>
    </div>
    <div class="menu-sidebar2__content js-scrollbar1">
        <div class="account2">
            <h3 class="name">Usuario:</h3>
            <h3 class="name">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h3>
            <form class="uk-margin-small-top" action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm" id="boton_logout">
                    <i class="fa fa-power-off"></i>&nbsp; Cerrar Sesión
                </button>
            </form>
        </div>
        <nav class="navbar-sidebar2">
            <ul class="list-inline navbar__list">
                <li class="entrada_panelPrincipal">
                    <a href="{{route('showHome')}}">
                        <i uk-icon="icon: grid"></i>Reclamos Técnicos</a>
                </li>
                <li class="entrada_historial">
                    <a href="{{route('showHistorialVisitas')}}" >
                        <i uk-icon="icon: history"></i>Reclamos Resueltos</a>
                </li>
                <li class="entrada_admins">
                    <a href="{{route('showAdminList')}}" >
                        <i uk-icon="icon: bolt"></i>Administradores</a>
                </li>
                <li class="entrada_userprofile">
                    <a href="{{route('userProfileSettings')}}" >
                        <i uk-icon="icon: cog"></i>Mi cuenta</a>
                </li>
                <li class="entrada_ayuda">
                    <a href="{{route('showAyuda')}}">
                        <i uk-icon="icon: question"></i>Ayuda</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- FIN MENU SIDEBAR-->

@include('plantillas.header')

<!-- MENU MOBILE-->
<aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none" onload="pintarTab(1)">
    <div class="logo">
        .
    </div>
    <div class="menu-sidebar2__content js-scrollbar2">
        <div class="account2">
            <h3 class="name">Usuario:</h3>
            <h4 class="name">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h4>
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm">
                    <i class="fa fa-power-off"></i>&nbsp; Cerrar Sesión
                </button>
            </form>
        </div>
        <nav class="navbar-sidebar2">
            <ul class="list-unstyled navbar__list">
                <li class="entrada_panelPrincipal">
                    <a href="{{route('showHome')}}">
                        <i uk-icon="icon: grid"></i>Reclamos Técnicos</a>
                </li>
                <li class="entrada_historial">
                    <a href="{{route('showHistorialVisitas')}}" >
                        <i uk-icon="icon: history"></i>Reclamos Resueltos</a>
                </li>
                <li class="entrada_admins">
                    <a href="{{route('showAdminList')}}" >
                        <i uk-icon="icon: bolt"></i>Administradores</a>
                </li>
                <li class="entrada_userprofile">
                    <a href="{{route('userProfileSettings')}}" >
                        <i uk-icon="icon: cog"></i>Mi cuenta</a>
                </li>
                <li class="entrada_cobranzas">
                    <a href="{{route('showAyuda')}}">
                        <i uk-icon="icon: question"></i>Ayuda</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU MOBILE-->

<script>
    // pintar la pestana lateral
    function pintarTab(tab_indx){
        // selectores de componentes html
        let entrada_panelPrincipal = document.querySelectorAll('.entrada_panelPrincipal');
        let entrada_historial = document.querySelectorAll('.entrada_historial');
        let entrada_administradores = document.querySelectorAll('.entrada_admins');
        let entrada_usuarioConfig = document.querySelectorAll('.entrada_userprofile');
        let entrada_ayuda = document.querySelectorAll('.entrada_ayuda');

        //despintar todo
        entrada_panelPrincipal.forEach(element => {
            element.classList.remove('active');
        });
        entrada_historial.forEach(element => {
            element.classList.remove('active');
        });
        entrada_administradores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_usuarioConfig.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ayuda.forEach(element => {
            element.classList.remove('active');
        });

        // pintar solo el indicado
        switch (tab_indx) {
            case 1:
                entrada_panelPrincipal.forEach(element => {
                    element.classList.add('active');
                });
                break;
            case 2:
                entrada_historial.forEach(element => {
                    element.classList.add('active');
                });
                break;
            case 3:
                entrada_administradores.forEach(element => {
                    element.classList.add('active');
                });
                break;
            case 4:
                entrada_usuarioConfig.forEach(element => {
                    element.classList.add('active');
                });
                break;
            case 5:
                entrada_ayuda.forEach(element => {
                    element.classList.add('active');
                });
                break;
        }
    }
</script>
