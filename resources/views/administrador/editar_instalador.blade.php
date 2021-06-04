@extends('layouts.esqueletoAdmin')

@section('estilos')
@endsection

@section('body')
    <!-- VENTANA EMERGENTE MODAL CAMBIAR CONTRASEÑA -->
    @include('administrador.modal.modal-cambiarContraseñaInstalador')
    <!-- FIN VENTANA EMERGENTE MODAL CAMBIAR CONTRASEÑA -->
    <!-- VENTANA EMERGENTE MODAL CAMBIAR DATOS PERSONALES -->
    @include('administrador.modal.modal-cambiarDatosPersonalesInstalador',['instalador'=>$detalle_instalador])
    <!-- FIN VENTANA EMERGENTE MODAL CAMBIAR DATOS PERSONALES -->

    <div class="section__content section__content--p30 uk-margin-top">
        <button type="button"
                id="boton_volver"
                class="btn btn-warning btn m-b-15">
            <i class="fa fa-arrow-left"></i> Volver al Listado
        </button>
        <div class="uk-child-width-1-2@s uk-grid-match" uk-grid>
            <div>
                <div class="uk-card uk-card-primary uk-card-hover uk-card-body uk-light">
                    <h3 class="uk-card-title">Contraseña</h3>
                    <p>Asignar otra contraseña de acceso</p>
                    <button class="uk-button uk-button-default mt-2"
                            uk-toggle="target: #modal-cambiarContraseñainstalador">Configurar
                    </button>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-secondary uk-card-hover uk-card-body uk-light">
                    <h3 class="uk-card-title">Datos personales</h3>
                    <p>Cambiar su teléfono o email</p>
                    <a
                        href="#modal-cambiarDatosinstalador" uk-toggle
                        class="uk-button uk-button-default mt-2">Configurar
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        /*
        * volver a la pagina anterior si se hace click sobre el boton "cancelar"
        * */
        document.getElementById('boton_volver').onclick = () => {
            window.history.go(-1);
        }
    </script>

    {{--     MENSAJE DE instalador CREADO SATISFACTORIAMENTE   --}}
    @isset($verificacion)
        <script>
            UIkit.notification({{ $verificacion }}, {
                status: 'success',
                pos: 'top-right',
                timeout: 3000
            });
        </script>
    @endisset
    {{--    FIN MENSAJE DE instalador CREADO SATISFACTORIAMENTE    --}}
    {{--     MENSAJE DE ERROR AL CREAR instalador   --}}
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                UIkit.notification('{{ $error }}', {
                    status: 'danger',
                    pos: 'top-right',
                    timeout: 7000
                });
            </script>
        @endforeach
    @endif
    {{--    FIN MENSAJE DE ERROR AL CREAR instalador   --}}
@endsection
