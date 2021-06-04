@extends('layouts.esqueletoAdmin')

@section('estilos')
    <link rel="stylesheet" href="{{asset('css/fstdropdown.css')}}">

@endsection

@section('body')
    <!-- VENTANA EMERGENTE MODAL CAMBIAR CONTRASEÑA -->
        @include('administrador.modal.modal-cambiarContraseñaAdministrador')
    <!-- FIN VENTANA EMERGENTE MODAL CAMBIAR CONTRASEÑA -->
    <!-- VENTANA EMERGENTE MODAL EDITAR NIVEL -->
        @include('administrador.modal.modal-cambiarNivelAdmin')
    <!-- FIN VENTANA EMERGENTE MODAL EDITAR NIVEL -->

        <div class="section__content section__content--p30 uk-margin-top">
            <div class="m-b-15">
                <button type="button" id="boton_volver" class="btn btn-warning btn-sm">
                    <i class="fa fa-rotate-left"></i> Volver al Listado
                </button>
            </div>
            <div class="uk-child-width-1-2@s uk-grid-match" uk-grid>
                <div>
                    <div class="uk-card uk-card-primary uk-card-hover uk-card-body uk-light">
                        <h3 class="uk-card-title">Contraseña</h3>
                        <p>Asignar otra contraseña de acceso</p>
                        <button class="uk-button uk-button-default mt-2" uk-toggle="target: #modal-cambiarContraseñaAdmin">Configurar</button>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-secondary uk-card-hover uk-card-body uk-light">
                        <h3 class="uk-card-title">Nivel de autoridad</h3>
                        <p>Cambiar el nivel de autoridad de un administrador para permitir o restringir determinadas acciones sobre la plataforma. Niveles más altos integran las funciones de los niveles mas bajos</p>

                        <button class="uk-button uk-button-default mt-2" uk-toggle="target: #modal-cambiarNivelAdmin">Configurar</button>
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
        document.getElementById('boton_volver').onclick=()=>{
            window.history.go(-1);
        }
    </script>

    {{--     MENSAJE DE COBRADOR CREADO SATISFACTORIAMENTE   --}}
    @isset($verificacion)
        <script>
            UIkit.notification({{ $verificacion }}, {
                status: 'success',
                pos: 'top-right',
                timeout: 3000
            });
        </script>
    @endisset
    {{--    FIN MENSAJE DE COBRADOR CREADO SATISFACTORIAMENTE    --}}
    {{--     MENSAJE DE ERROR AL CREAR COBRADOR   --}}
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
    {{--    FIN MENSAJE DE ERROR AL CREAR COBRADOR   --}}
@endsection
