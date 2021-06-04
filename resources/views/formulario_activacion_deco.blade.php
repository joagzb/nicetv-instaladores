@extends('layouts.esqueletoInstalador')

@section('body')
    <div class="container-fluid">
        <section class="section__content section__content--p30">
            <div class="row uk-margin-top">
                <div class="col-12">
                    <form method="post"
                          action="{{route('post_activarDeco',
                          ['Arg_idreclamo'=> \Illuminate\Support\Facades\Route::current()->parameters()['Arg_idreclamo']])}}">
                        @csrf
                        <div class="user-data m-b-20 rounded-top uk-border-rounded">
                            <div class="uk-margin">
                                <h5 class="text-center heading-title">Para acreditar la instalación, complete
                                    con los datos del
                                    titular del servicio</h5>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="input_nombre"
                                                       class=" form-control-label">Nombre y
                                                    Apellido</label>
                                                <input type="text"
                                                       id="input_nombre"
                                                       name="nombre"
                                                       minlength="6"
                                                       maxlength="100"
                                                       class="form-control"
                                                       value="{{$cliente_info['nombre']}} {{$cliente_info['apellido']}}"
                                                       required>
                                                <small class="form-text text-muted">(campo obligatorio) </small>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="input_email"
                                                       class=" form-control-label">Email</label>
                                                <input type="email"
                                                       id="input_email"
                                                       name="email"
                                                       minlength="8"
                                                       maxlength="60"
                                                       required
                                                       value="{{ $cliente_info["mail"] }}"
                                                       class="form-control">
                                                <small class="form-text text-muted">(campo obligatorio)@error('email')
                                                    {{ $message }}
                                                    @enderror</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="input_dni"
                                                       class=" form-control-label">DNI</label>
                                                <input type="number"
                                                       id="input_dni"
                                                       name="dni"
                                                       minlength="8"
                                                       maxlength="12"
                                                       value="{{ $cliente_info["dni"] }}"
                                                       class="form-control"
                                                       required>
                                                <small class="form-text text-muted">(campo
                                                    obligatorio) @error('dni')
                                                    {{ $message }}
                                                    @enderror</small>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="input_telefono"
                                                       class=" form-control-label">Teléfono</label>
                                                <input type="number"
                                                       id="input_telefono"
                                                       name="telefono"
                                                       minlength="8"
                                                       maxlength="20"
                                                       value="{{ $cliente_info["telefono"] }}"
                                                       class="form-control"
                                                       required>
                                                <small class="form-text text-muted">(campo
                                                    obligatorio) @error('telefono')
                                                    {{ $message }}
                                                    @enderror</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="input_calle"
                                                       class=" form-control-label">Calle</label>
                                                <input type="text"
                                                       id="input_calle"
                                                       name="calle"
                                                       minlength="6"
                                                       maxlength="100"
                                                       value="{{ old('calle') }}"
                                                       class="form-control"
                                                       required>
                                                <small class="form-text text-muted">(campo
                                                    obligatorio) @error('calle')
                                                    {{ $message }}
                                                    @enderror</small>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="input_casa_nro"
                                                       class=" form-control-label">Nro de
                                                    casa</label>
                                                <input type="text"
                                                       id="input_casa_nro"
                                                       name="casa_nro"
                                                       value="{{ old('casa_nro') }}"
                                                       class="form-control"
                                                       required>
                                                <small class="form-text text-muted">(campo
                                                    obligatorio) @error('casa_nro')
                                                    {{ $message }}
                                                    @enderror</small>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="input_barrio"
                                                       class=" form-control-label">Barrio</label>
                                                <input type="text"
                                                       id="input_barrio"
                                                       name="barrio"
                                                       value="{{ old('barrio') }}"
                                                       class="form-control">
                                                <small class="form-text text-muted">@error('barrio')
                                                    {{ $message }}
                                                    @enderror</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_detalles"
                                               class="
                                            form-control-label">Detalles que anexar</label>
                                        <input type="text"
                                               id="input_detalles"
                                               name="detalle"
                                               value="{{ old('detalle') }}"
                                               class="form-control">
                                        <small class="form-text text-muted">@error('detalles')
                                            {{ $message }}
                                            @enderror</small>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="input_tipo_servicio"
                                                       class=" form-control-label">Nombre del servicio del
                                                    cliente
                                                </label>
                                                <input type="text"
                                                       id="input_tipo_servicio"
                                                       name="tipo_servicio"
                                                       class="form-control"
                                                       value="{{ old('tipo_servicio') }}"
                                                       required>
                                                <small class="form-text text-muted">(campo
                                                    obligatorio) @error('tipo_servicio')
                                                    {{ $message }}
                                                    @enderror</small>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="input_kid"
                                                       class=" form-control-label">KID deco
                                                    1</label>
                                                <input type="text"
                                                       id="input_kid"
                                                       name="kid1"
                                                       minlength="3"
                                                       maxlength="15"
                                                       class="form-control"
                                                       value="{{ old('kid1') }}"
                                                       required>
                                                <small class="form-text text-muted">(campo
                                                    obligatorio) @error('kid')
                                                    {{ $message }}
                                                    @enderror</small>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="input_kid"
                                                       class=" form-control-label">KID deco 2
                                                    opcional</label>
                                                <input type="text"
                                                       id="input_kid"
                                                       name="kid2"
                                                       minlength="3"
                                                       maxlength="15"
                                                       class="form-control">
                                                <small class="form-text text-muted">@error('kid')
                                                    {{ $message }}
                                                    @enderror</small>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="payment-button"
                                            type="submit"
                                            class="btn btn-lg btn-info btn-block">
                                        <i class="fa fa-lock fa-lg"></i>&nbsp;
                                        <span id="payment-button-amount">ACTIVAR</span>
                                    </button>
                                    <button id="payment-button"
                                            type="button"
                                            onclick="volverAtras()"
                                            class="btn btn-lg btn-outline-danger btn-block">
                                        <span id="payment-button-amount">CANCELAR</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
        function volverAtras(){
            window.history.go(-1);
        }
    </script>

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
