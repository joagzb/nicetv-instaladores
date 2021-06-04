<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>instaladores NicetTV - recuperar contraseña</title>
</head>
<body>
Buenos días {{ $nombre_usuario }}
<br>
<br>
Usted ha solicitado recuperar su contraseña de acceso. Haga click en el siguiente enlace para que pueda
ingresar una contraseña nueva.
<ul>
    <li><a href="{{$link_reset}}">{{$link_reset}}</a></li>
</ul>
<br>
<br>
Si usted no ha solicitado esto, por favor ignore y elimine este email.
<br>
<br>
Atentamente,
<br>
El equipo de NiceTV
</body>
</html>
