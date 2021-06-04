@extends('layouts.esqueleto')

@section('disenos')

    @yield('estilos')
@endsection

@section('cuerpo')
    <div class="page-wrapper">
        @include('plantillas.sidebar_instalador')

        @yield('body')
    </div>
@endsection

@section('funciones')
    @yield('scripts')

@endsection
