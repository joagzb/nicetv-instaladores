@extends('layouts.esqueleto')

@section('disenos')
    <style>
        .au-btn {
            background-color: darkorange;
            color: white;
            border: solid 2px orange;
        }

        .au-btn:hover {
            background-color: white;
            color: darkorange;
            border: solid 2px orange;
        }

        .au-btn:focus {
            background-color: white;
            color: darkorange;
            border: solid 2px orange;
        }

    </style>
@endsection

@section('cuerpo')
    <div class="page-wrapper-aux">
        <div class="page-content--bge5-transparent">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <img src="{{asset('assets/imgs/nice_logo.png')}}" alt="NiceTV Logo" width="120px">
                    </div>
                    <div class="login-form">
                        <h2 class="title-2 text-center ">Nueva Contraseña</h2>
                        <hr>
                        <form method="POST" action="{{ route('post_email_form_recovery',['idusuario'=>$id])}}">
                            @csrf

                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input
                                    class="au-input au-input--full form-control @error('password') is-invalid @enderror"
                                    id="password" type="password" name="password"
                                    value="{{ old('password') }}" minlength="6" required
                                    autofocus>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Repita Contraseña</label>
                                <input
                                    class="au-input au-input--full form-control"
                                    id="password_confirmation" type="password" name="password_confirmation"
                                    minlength="6" required>
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button class="au-btn au-btn--block m-b-20" type="submit">Continuar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('funciones')
    @isset($payload['ok'])
        <script>
            UIkit.notification({
                message: '<div class="uk-alert uk-alert-info">{{ $payload['ok'] }}</div>',
                status: 'error',
                pos: 'top-right',
                timeout: 3000
            });
        </script>
    @endisset
    @isset($payload['error'])
        <script>
            UIkit.notification({
                message: '<div class="uk-alert uk-alert-danger">{{ $payload['error'] }}</div>',
                status: 'error',
                pos: 'top-right',
                timeout: 3000
            });
        </script>
    @endisset
@endsection




