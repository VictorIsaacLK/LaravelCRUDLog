<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mensaje de Bienvenida</title>
</head>
<body>
    <h1>Bienvenido a nuestro sistema {{$name}}</h1>

    <P>Para poder darte de alta en nuestro sistema y acceder a más opciones, lo que tienes que hacer es lo siguiente:</P>
    <br>
    <p>Primero, tienes que entrar insertar la siguiente URL en la aplicación de Insomnia, con el METODO POST: </p>
    <a href="{{$url}}">URL</a>
    <p>Y despues, ponemos el siguiente ejemplo de estructura JSON, con TUS propios DATOS:<br>
        <br>
        &nbsp{<br>
            &nbsp&nbsp"email":"noreply@hotmail.com",<br>
            &nbsp&nbsp"numero":0000000000<br>
        &nbsp}<br>
        <br>
    </p>
    <p>Finalizando con enviar la informacion con el boton de "SEND"</p>


    
    {{-- <a class="fcc-btn" href="second.blade.php">Link</a> --}}
    {{-- <p>http://25.7.42.39:8000/api/httpEx/verificacion</p> --}}
</body>
</html>