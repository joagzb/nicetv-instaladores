@extends(\Illuminate\Support\Facades\Auth::user()->userRole()==\App\Models\User::USER_ADMIN_TYPE ? 'layouts.esqueletoAdmin':'layouts.esqueletoInstalador')


@section('estilos')
    <style>
        .tab-title {
            font-size: 18px;
        }

        .content {
            padding-left: 0;
            padding-right: 0;
        }

    </style>
@endsection

@section('body')
    <div class="container-fluid">
        <section class="section__content section__content--p30 uk-margin-top">
            <button type="button" id="boton_volver" class="btn btn-warning btn m-b-15">
                <i class="fa fa-arrow-left"></i> Volver al Listado
            </button>
            <div class="row">
                <div class="col-12">
                    <div class="user-data rounded-top uk-border-rounded uk-padding-small">
                        <div uk-grid>
                            <div class="uk-width-auto@m grid-details">
                                <ul class="uk-tab-left"
                                    uk-tab="connect: #component-tab-left; animation: uk-animation-fade">
                                    <li><a href="#"><span class="tab-title">RECLAMO</span></a></li>
                                    <li><a href="#"><span class="tab-title">DETALLES DEL CLIENTE</span></a></li>
                                </ul>
                            </div>
                            <div class="uk-width-expand@m content">
                                <ul id="component-tab-left"
                                    class="uk-switcher">
                                    <li>
                                        <div class="uk-section uk-section-small uk-section-default">
                                            <div class="uk-container">
                                                <div class="uk-grid-match uk-child-width-1-3@l"
                                                     uk-grid>

                                                    <div>
                                                        <h4 class="uk-margin-small-bottom">Motivo:</h4>
                                                        <p class="uk-text-italic uk-text-justify
                                                        uk-text-lowercase uk-margin-small-bottom">{{$detalle_reclamo->motivo}}</p>
                                                        <p class="uk-text-meta uk-text-center">{{$detalle_reclamo->fechareclamo}}</p>
                                                        <ul class="uk-list">
                                                            <li><u>nro de reclamo:</u>
                                                                {{$detalle_reclamo->id_reclamo}}</li>
                                                            <li><u>detalles:</u>
                                                                {{$detalle_reclamo->detalles}}</li>
                                                        </ul>
                                                    </div>

                                                    <div>
                                                        <h4 class="uk-margin-small-bottom">
                                                            KiD Decodificadores:</h4>
                                                        <p>{{$detalle_reclamo->id_deco}}</p>
                                                    </div>

                                                    <div>
                                                        <h4 class="uk-margin-small-bottom">Informador:</h4>
                                                        <p class="uk-text-italic uk-text-justify
                                                        uk-text-lowercase uk-margin-small-bottom">{{$detalle_reclamo->nombre_instalador_responsable}}</p>
                                                        <br>
                                                        <p class="uk-text-warning">Resuelto el
                                                            {{$detalle_reclamo->fecha_operacion}}</p>
                                                        <br>
                                                        <p class="uk-text-warning uk-text-lowercase">
                                                            {{$detalle_reclamo->Localidad}}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="uk-section uk-section-small uk-section-default">
                                            <div class="uk-container">
                                                <div class="uk-grid-match uk-child-width-1-1@l"
                                                     uk-grid>

                                                    <div>
                                                        <h4 class="uk-margin-small-bottom">Datos
                                                            personales:</h4>
                                                            <ul class="uk-list">
                                                                <li><u>Abonado:</u>
                                                                    {{$detalle_reclamo->cliente_nroabonado}}</li>
                                                                <li>
                                                                    <u>Nombre:</u> {{$detalle_reclamo->nombre_apellido_abonado}}
                                                                </li>
                                                                <li><u>Telefono del titular registrado:</u>
                                                                    {{$detalle_reclamo->telefono_confirmado}}</li>
                                                                <li><u>Email del titular registrado:</u>
                                                                    {{$detalle_reclamo->email_confirmado}}</li>
                                                            </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
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
