<ul class="list-inline navbar__list">

    @if(\Illuminate\Support\Facades\Auth::user()->userRole()==\App\Models\User::USER_INSTALADOR_TYPE)

        <li @if(\Illuminate\Support\Facades\Session::get('tabnav')===\App\Http\Middleware\tabPainter::paths[0]) class="active" @endif>
            <a href="{{route('showHome')}}">
                <i uk-icon="icon: grid"></i>Reclamos Técnicos</a>
        </li>
        <li @if(\Illuminate\Support\Facades\Session::get('tabnav')===\App\Http\Middleware\tabPainter::paths[1]) class="active" @endif>
            <a href="{{route('showHistorialVisitas')}}">
                <i uk-icon="icon: history"></i>Reclamos Resueltos</a>
        </li>

    @else

        <li @if(\Illuminate\Support\Facades\Session::get('tabnav')===\App\Http\Middleware\tabPainter::paths[6]) class="active" @endif>
            <a href="{{route('showHomeAdmin')}}">
                <i uk-icon="icon: grid"></i>Panel principal</a>
        </li>
        <li @if(\Illuminate\Support\Facades\Session::get('tabnav')===\App\Http\Middleware\tabPainter::paths[5]) class="active" @endif>
            <a href="{{route('showInstaladores')}}">
                <i uk-icon="icon: users"></i>Instaladores</a>
        </li>

    @endif

    <li @if(\Illuminate\Support\Facades\Session::get('tabnav')===\App\Http\Middleware\tabPainter::paths[3]) class="active" @endif>
        <a href="{{route('showAdminList')}}">
            <i uk-icon="icon: bolt"></i>Administradores</a>
    </li>
    <li @if(\Illuminate\Support\Facades\Session::get('tabnav')===\App\Http\Middleware\tabPainter::paths[4]) class="active" @endif>
        <a href="{{route('userProfileSettings')}}">
            <i uk-icon="icon: cog"></i>Preferencias usuario</a>
    </li>
    <li @if(\Illuminate\Support\Facades\Session::get('tabnav')===\App\Http\Middleware\tabPainter::paths[2]) class="active" @endif>
        <a href="{{route('showAyuda')}}">
            <i uk-icon="icon: question"></i>Ayuda</a>
    </li>

</ul>
