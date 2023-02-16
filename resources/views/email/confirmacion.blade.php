<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Codigo de confirmacion</title>
</head>
<body>
    <h1>Hola de nuevo {{$name}}!</h1>

    <p>Es un placer verte de nuevo.</p><br>
    <p>Para terminar con tu registro, lo ultimo que necesitamos es que ingreses la siguiente URL</p>
    <a href="{{$url}}">URL</a>
    <p>En el sistema Insomnia con el metodo POST con la siguiente estructura <br>
        <br>
        &nbsp{<br>
            &nbsp&nbsp"email":"noreply@hotmail.com",<br>
            &nbsp&nbsp"code":00000<br>
        &nbsp}<br>
        <br>
    </p>
    <p>En donde, por supuesto, el code <strong>es el CODE que mandamos a tu celular</strong></p>
    
</body>
</html>