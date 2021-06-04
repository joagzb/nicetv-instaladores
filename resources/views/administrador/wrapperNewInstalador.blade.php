@extends('layouts.esqueletoAdmin')

@section('estilos')
    <link rel="stylesheet"
          href="{{asset('css/fstdropdown.css')}}">

    <style>
        .uk-card-first-option {
            background-color: #0f6ecd;
            cursor: pointer;
            border: solid 2px transparent;
            transition: ease 200ms;
        }

        .uk-card-second-option {
            background-color: #7c2d2b;
            border: solid 2px transparent;
            cursor: pointer;
            transition: ease 300ms;
        }

        .uk-card-title {
            color: white;
        }

        .uk-card-first-option:hover {
            background-color: white;
            cursor: pointer;
            border: solid 2px #0f6ecd;
            color: #0f6ecd;
        }

        .uk-card-second-option:hover {
            background-color: white;
            cursor: pointer;
            border: solid 2px #7c2d2b;
            color: #7c2d2b;
        }

        .uk-card-second-option:hover .uk-card-title {
            color: #7c2d2b;
        }

        .uk-card-first-option:hover .uk-card-title {
            color: #0f6ecd;
        }
    </style>
@endsection

@section('body')
    {{-- MODAL IMPORTACION USUARIO DE PLAT.COBRADORES  --}}
    @isset($usersCobradores)
        @include('administrador.modal.modal-selectCobradorAPI',['usersCobradores'=>$usersCobradores])
    @endisset
    {{-- FIN MODAL IMPORTACION USUARIO DE PLAT.COBRADORES   --}}

    <div class="section__content section__content--p30 uk-margin-top">
        <div class="container-fluid">
            <button type="button"
                    id="boton_volver"
                    class="btn btn-warning btn m-b-15">
                <i class="fa fa-arrow-left"></i> Volver al Listado
            </button>
            <div class="row uk-margin-top">
                <div class="col-12">
                    <div class="user-data rounded-top uk-border-rounded uk-padding-large">
                        <div class="uk-child-width-1-2@m uk-grid-match uk-container col col-12"
                             uk-grid>
                            <div>
                                <div  uk-toggle="target: #modal-selectCobradorAPI"
                                     class="uk-card uk-card-small uk-border-rounded uk-card-first-option uk-card-body
                                uk-padding-large">
                                    <h3 class="uk-card-title text-center">Importar desde plataforma de
                                        cobradores
                                    </h3>
                                </div>
                            </div>
                            <div>
                                <div
                                    onclick="window.location='{{ route('showCreateInstaladorOptions',
                                    ['option'=>'nuevo']) }}'"
                                    class="uk-card uk-card-small uk-border-rounded uk-card-second-option uk-card-body
                                uk-padding-large">
                                    <h3 class="uk-card-title text-center">Generar nuevo usuario</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/fstdropdown.min.js')}}"></script>

    <script>
        /*
        * volver a la pagina anterior si se hace click sobre el boton "cancelar"
        * */
        document.getElementById('boton_volver').onclick = () => {
            window.history.go(-1);
        }
    </script>
@endsection
