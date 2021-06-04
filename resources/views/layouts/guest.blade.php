<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>NiceTV - Instaladores</title>
        <meta name="Plataforma del servicio de NiceTV para la operación de instalaciones del servicio y reclamos"
              content="Aplicación web para instaladores del servicio NiceTV">
        <meta name="author" content="Gonzalez Budinho Joaquin Mariano">

        <!-- UIKIT -->
        <link rel="stylesheet" href="{{asset('css/uikit.min.css')}}" />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        <!-- UIKIT -->
        <script src="{{asset('js/uikit.min.js')}}"></script>
        <script src="{{asset('js/uikit-icons.min.js')}}"></script>
    </body>
</html>
