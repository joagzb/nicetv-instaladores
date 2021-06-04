<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo/>
            <h3>Aplicación Web para Instaladores</h3>
            <br>
        </x-slot>


        <x-jet-validation-errors class="mb-4"/>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif


        <form method="POST"
              action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email"
                             value="{{ __('Email') }}"/>
                <x-jet-input id="email"
                             class="block mt-1 w-full"
                             type="email"
                             name="email"
                             :value="old('email')"
                             required
                             autofocus/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password"
                             value="{{ __('Contraseña') }}"/>
                <x-jet-input id="password"
                             class="block mt-1 w-full"
                             type="password"
                             name="password"
                             required
                             autocomplete="current-password"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                   uk-toggle
                   href="#modal_reiniciarPassword">
                    {{ __('¿Olvidó su contraseña?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Ingresar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>

<div id="modal_reiniciarPassword"
     class="uk-modal"
     uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Recuperar contraseña</h2>
        <p>
            Si usted desea recuperar la contraseña de su cuenta, por favor, ingrese el correo electrónico
            con el cual está registrado. Recibirá un email con un enlace, donde al hacer click podrá
            recuperar su contraseña.
        </p>
        <br>

        <form method="post"
              action="{{ route('email_recovery') }}"
              class="uk-grid-small uk-display-block uk-form-stacked"
              uk-grid>
            @csrf
            <div class="uk-grid-collapse"
                 uk-grid>
                <div class="uk-width-expand">
                    <label for="form-stacked-text">Email con el que accede</label>
                    <div class="uk-inline uk-width-expand">
                        <span class="uk-form-icon"
                              uk-icon="icon: mail"></span>
                        <input class="uk-input uk-form-large uk-padding-large-left"
                               id="form-stacked-text"
                               type="email"
                               name="email"
                               minlength="6"
                               required/>
                    </div>
                </div>
            </div>

            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-box-shadow-hover-small"
                        type="button">
                    Cancelar
                </button>
                <button class="uk-button uk-button-primary"
                        type="submit">
                    Continuar
                </button>
            </p>
        </form>
    </div>
</div>

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
{{--    FIN MENSAJE OK    --}}{{--     MENSAJE DE ERROR  --}}
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
