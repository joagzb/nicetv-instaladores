@extends('layouts.esqueletoAdmin')

@section('estilos')
    <link rel="stylesheet"
          href="{{asset('css/stepform.css')}}">
@endsection

@section('body')
    <form class="multisteps-form__form"
          method="post"
          action="{{route('createAdmin')}}">
        @csrf
        <div class="container-fluid uk-margin-top">
            <div class="section__content section__content--p30">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="title-5 m-b-35 text-center">Formulario de alta de Administrador</h3>
                    </div>
                </div>
                <div class="multisteps-form">
                    <!--progress bar-->
                    <div class="row">
                        <div class="col-12 col-lg-8 ml-auto mr-auto mb-4">
                            <div class="multisteps-form__progress">
                                <button class="multisteps-form__progress-btn js-active"
                                        type="button"
                                        title="Datos personales">Datos Personales
                                </button>
                                <button class="multisteps-form__progress-btn"
                                        type="button"
                                        title="Credenciales de acceso">
                                    Credenciales de acceso
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--form panels-->
                    <div class="row">
                        <div class="col-12 col-lg-8 m-auto">
                            <!--single form panel-->
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active"
                                 data-animation="scaleIn">
                                <h3 class="multisteps-form__title">Datos personales</h3>
                                <div class="multisteps-form__content">
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-12">
                                            <input class="multisteps-form__input form-control"
                                                   id="input_nombre"
                                                   name="input_nombre"
                                                   value="{{ old('input_nombre') }}"
                                                   type="text"
                                                   placeholder="Nombre y Apellido"
                                                   required/>
                                            <small class="form-text text-muted">(campo
                                                obligatorio) @error('input_nombre')
                                                {{ $message }}
                                                @enderror</small>
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-12">
                                            <div class="form-check">
                                                <div class="radio">
                                                    <label for="radio1"
                                                           class="form-check-label ">
                                                        <input type="radio"
                                                               name="radios"
                                                               value="1"
                                                               class="form-check-input"> Nivel 1 - Control
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="radio2"
                                                           class="form-check-label ">
                                                        <input type="radio"
                                                               name="radios"
                                                               value="2"
                                                               class="form-check-input"> Nivel 2 - Gestión
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="radio2"
                                                           class="form-check-label ">
                                                        <input type="radio"
                                                               name="radios"
                                                               value="3"
                                                               class="form-check-input"> Nivel 3 - Super Usuario
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-row d-flex mt-4">
                                        <button class="btn btn-danger"
                                                type="button"
                                                title="cancelar"
                                                id="boton_cancelar">
                                            Cancelar
                                        </button>
                                        <button class="btn btn-primary ml-auto js-btn-next"
                                                type="button"
                                                title="Next">Siguiente
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white"
                                 data-animation="scaleIn">
                                <h3 class="multisteps-form__title">Credenciales de acceso</h3>
                                <div class="multisteps-form__content">
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-12">
                                            <input type="email"
                                                   id="email-input"
                                                   name="email-input"
                                                   value="{{ old('email-input') }}"
                                                   placeholder="Email"
                                                   class="multisteps-form__input form-control"
                                                   required>
                                            <small class="help-block form-text">(campo
                                                obligatorio) @error('email-input')
                                                {{ $message }}
                                                @enderror</small>
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-12">
                                            <input type="text"
                                                   id="password-input"
                                                   name="password-input"
                                                   class="multisteps-form__input form-control"
                                                   placeholder="Contraseña"
                                                   value="{{ old('password-input') }}"
                                                   required>
                                            <small class="help-block form-text">(campo
                                                obligatorio) @error('password-input')
                                                {{ $message }}
                                                @enderror</small>
                                        </div>

                                    </div>
                                    <div class="button-row d-flex mt-4">
                                        <button class="btn btn-primary js-btn-prev"
                                                type="button"
                                                title="Prev">
                                            Atrás
                                        </button>
                                        <button class="btn btn-success ml-auto"
                                                type="submit"
                                                title="Send">
                                            CREAR
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{asset('js/admins.js')}}"></script>
    <script src="{{asset('js/stepform.js')}}"></script>

    <script>
        /*
        * volver a la pagina anterior si se hace click sobre el boton "cancelar"
        * */
        document.getElementById('boton_cancelar').onclick = () => {
            window.history.go(-1);
        }
    </script>
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
