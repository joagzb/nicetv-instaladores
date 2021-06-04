@extends(\Illuminate\Support\Facades\Auth::user()->userRole()=='admin' ? 'layouts.esqueletoAdmin':'layouts.esqueletoInstalador')

@section('estilos')
@endsection

@section('body')
    <div class="container-fluid uk-margin-top">
        <div class="section__content section__content--p30">
            <div class="uk-child-width-1-2@s uk-grid-match"
                 uk-grid>
                    <div>
                        <div class="uk-card uk-card-primary uk-card-hover uk-card-body uk-light">
                            <h3 class="uk-card-title">Su contraseña de acceso</h3>
                            <button uk-toggle="target: #modal-cambiarContrasena"
                                    class="uk-button uk-button-default mt-2">cambiar
                            </button>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    {{--MODAL CAMBIAR CONTRASENA--}}
    <div id="modal-cambiarContrasena"
         uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default"
                    type="button"
                    uk-close></button>
            <form action="{{route('post_email_form_recovery',[
            'idusuario'=>encrypt(\Illuminate\Support\Facades\Auth::user()->id) ])}}"
                  method="post">
                @csrf
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Ingrese nueva contraseña</h2>
                </div>
                <div class="uk-modal-body">
                    <div class="uk-margin">
                            <input class="uk-input"
                                   name="password"
                                   type="text"
                                   max="30"
                                   min="4"
                                   placeholder="nueva contraseña"
                                   required>
                    </div>
                    <div class="uk-margin">
                            <input class="uk-input"
                                   name="password_confirmation"
                                   type="text"
                                   max="30"
                                   min="4"
                                   placeholder="confirmar nueva contraseña"
                                   required>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close"
                            type="button">Cancelar</button>
                    <button class="uk-button uk-button-primary"
                            type="submit">Cambiar
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{--FIN MODAL CAMBIAR CONTRASENA--}}
@endsection

@section('scripts')
    {{--     MENSAJE OK  --}}
    @if(\Illuminate\Support\Facades\Session::has('ok'))
        <script>
            UIkit.notification("{{ \Illuminate\Support\Facades\Session::get('ok') }}", {
                status: 'success',
                pos: 'top-right',
                timeout: 3000
            });
        </script>
    @endif
    {{--    FIN MENSAJE OK    --}}
    {{--     MENSAJE DE ERROR  --}}
    @if(\Illuminate\Support\Facades\Session::has('error'))
        <script>
            UIkit.notification('{{ \Illuminate\Support\Facades\Session::get('error')}}', {
                status: 'danger',
                pos: 'top-right',
                timeout: 7000
            });
        </script>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                UIkit.notification('{{$error}}', {
                    status: 'danger',
                    pos: 'top-right',
                    timeout: 7000
                });
            </script>
        @endforeach
    @endif
    {{--    FIN MENSAJE DE ERROR  --}}
@endsection
