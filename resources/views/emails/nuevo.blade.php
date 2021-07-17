<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <h1>{{$titulo}}</h1>
    <hr>
    <p>Estimado usuario, se ha registrado un nuevo pedido con el número: <b>{{$contenido["pedido"]}}</b></p>
    <p>Puede verificarlo en el enlace a continuación:</p>
    <a href="{{$contenido['enlace']}}">{{$contenido["enlace"]}}</a>
</body>
</html>
