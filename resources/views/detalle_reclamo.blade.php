@extends(\Illuminate\Support\Facades\Auth::user()->userRole()==\App\Models\User::USER_ADMIN_TYPE ? 'layouts.esqueletoAdmin':'layouts.esqueletoInstalador')


@section('estilos')
    <style>
        .tab-title{
            font-size: 18px;
        }
    </style>
    @if(\Illuminate\Support\Facades\Auth::user()->userRole()==\App\Models\User::USER_INSTALADOR_TYPE)
        <style>
            .grid-details{
                padding-left: 5px;
            }
        </style>
    @endif
@endsection

@section('body')
    {{--  MODAL MARCAR EL RECLAMO COMO RESUELTO  --}}
    @if(\Illuminate\Support\Facades\Auth::user()->userRole()==\App\Models\User::USER_INSTALADOR_TYPE && isset($detalle_reclamo->cliente_info))
        @include('modal.modal-marcarReclamoResuelto',['detalle_reclamo'=>$detalle_reclamo])
    @endif
    {{--  FIN MODAL MARCAR EL RECLAMO COMO RESUELTO  --}}

    <div class="container-fluid">
        <section class="section__content section__content--p30 uk-margin-top">
            <button type="button" id="boton_volver" class="btn btn-warning btn m-b-15">
                <i class="fa fa-arrow-left"></i> Volver al Listado
            </button>
            <div class="row">
                <div class="col-12">
                    <div class="user-data rounded-top uk-border-rounded uk-padding-small">
                        @if(!\Illuminate\Support\Facades\Auth::user()->userRole()
                        ==\App\Models\User::USER_INSTALADOR_TYPE)
                            @if ($detalle_reclamo->idtiporeclamo == 2)
                                <a href="{{route('showFormActivacion',
                                ['Arg_idreclamo'=>\Illuminate\Support\Facades\Route::current()->parameters()['Arg_idreclamo'],
                                'params'=>$detalle_reclamo->cliente_info])}}"
                                   class="btn btn-outline-success btn-sm float-right">Resolver Instalación</a>
                            @else
                                <a class="btn btn-outline-success btn-sm float-right "
                                   href="#modal-marcarReclamoResuelto"
                                   uk-toggle>Marcar resuelto</a>
                            @endif
                        @endif
                        @if(isset($detalle_reclamo->cliente_info))
                            <div uk-grid>
                                <div class="uk-width-auto@m grid-details">
                                    <ul class="uk-tab-left"
                                        uk-tab="connect: #component-tab-left; animation: uk-animation-fade">
                                        <li><a href="#"><span class="tab-title">RECLAMO</span></a></li>
                                        <li><a href="#"><span class="tab-title">DETALLES DEL CLIENTE</span></a></li>
                                    </ul>
                                </div>
                                <div class="uk-width-expand@m">
                                    <ul id="component-tab-left"
                                        class="uk-switcher">
                                        <li>
                                            <div class="uk-section uk-section-small uk-section-default">
                                                <div class="uk-container">

                                                    <div class="uk-grid-match uk-child-width-1-2@m"
                                                         uk-grid>
                                                        <div>
                                                            <h4 class="uk-margin-small-bottom">Motivo:</h4>
                                                            <p class="uk-text-italic uk-text-justify
                                                            uk-text-lowercase uk-margin-small-bottom">{{$detalle_reclamo->motivo}}</p>
                                                            <p class="uk-text-meta uk-text-center">{{$detalle_reclamo->fechareclamo}}</p>
                                                        </div>
                                                        <div>
                                                            <h4 class="uk-margin-small-bottom">
                                                                Decodificadores:</h4>
                                                            <ul>
                                                                @if(isset($detalle_reclamo->deco) && $detalle_reclamo->deco!='')
                                                                    <li>{{$detalle_reclamo->deco}}</li>
                                                                @endif
                                                                @if(isset($detalle_reclamo->deco2) && $detalle_reclamo->deco2!='')
                                                                    <li>{{$detalle_reclamo->deco2}}</li>
                                                                @endif
                                                                @if(isset($detalle_reclamo->des_estado) && $detalle_reclamo->des_estado!='')
                                                                    <li>{{$detalle_reclamo->des_estado}}</li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-section uk-section-small uk-section-default">
                                                <div class="uk-container">

                                                    <div class="uk-grid-match uk-child-width-1-2@m"
                                                         uk-grid>

                                                        <div>
                                                            <h4 class="uk-margin-small-bottom">Datos
                                                                personales:</h4>
                                                            @isset($detalle_reclamo->cliente_info)
                                                                <ul class="uk-list">
                                                                    <li>Abonado: {{$detalle_reclamo->idabonado}}</li>
                                                                    <li>
                                                                        Nombre: {{$detalle_reclamo->cliente_info->nombre}} {{$detalle_reclamo->cliente_info->apellido}}
                                                                    </li>
                                                                    <li>telefono: {{$detalle_reclamo->cliente_info->telefono}}</li>
                                                                    <li>mail: {{$detalle_reclamo->cliente_info->mail}}</li>
                                                                    <li>
                                                                        observaciones: {{$detalle_reclamo->cliente_info->observaciones}}</li>
                                                                </ul>
                                                            @endisset
                                                        </div>

                                                        <div>
                                                            <h4 class="uk-margin-small-bottom">Ubicación:</h4>
                                                            @isset($detalle_reclamo->localidad_cliente)
                                                                <ul class="uk-list">
                                                                    <li>Localidad: {{$detalle_reclamo->localidad_cliente->ciudad}}
                                                                        - {{$detalle_reclamo->localidad_cliente->padre}}</li>
                                                                    <li>
                                                                        Direccion: {{$detalle_reclamo->localidad_cliente->nieto}} {{$detalle_reclamo->localidad_cliente->nrocasa}}
                                                                        , {{$detalle_reclamo->localidad_cliente->hijo}} </li>
                                                                    </ul>
                                                                    <div>
                                                                        <a href="{{$detalle_reclamo->link_gmaps}}"
                                                                           target="_blank"
                                                                           class="btn btn-sm btn-block
                                                                           btn-outline-primary">
                                                                            <i class="fa fa-map-marker"></i>&nbsp; Ver en Google Maps
                                                                        </a>
                                                                    </div>
                                                            @endisset
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="col-md-12">
                        <div class="card border border-secondary">
                            <div class="card-body">
                                <p class="card-text">
                                    No se ha encontrado al cliente deseado en la base de datos de billing
                                </p>
                            </div>
                        </div>
                    </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    {{--  boton de volver al listado  --}}
    <script>
        /*
        * volver a la pagina anterior si se hace click sobre el boton "cancelar"
        * */
        document.getElementById('boton_volver').onclick = () => {
            window.history.go(-1);
        }
    </script>

    {{--     MENSAJE DE ERROR AL ENVIAR FORMULARIO DE COBRO  --}}
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                UIkit.notification('{{ $error }}', {
                    status: 'danger',
                    pos: 'top-center',
                    timeout: 5000
                });
            </script>
        @endforeach
    @endif
    {{--    FIN MENSAJE DE ERROR AL ENVIAR FORMULARIO DE COBRO   --}}
@endsection
