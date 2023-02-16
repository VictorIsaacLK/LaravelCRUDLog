<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Juego</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav><br>

    <div class="row">
        <div class="col-2">
        </div>
        <div class="col-8" align="center">
            <h1>Agrega el juego que quieras!</h1>
            <form method="POST">
              @csrf
              <div class="mb"><br>
                <label for="nombre" class="form-label">Nombre del Videojuego a agregar</label>
                <input type="text" name="nombre" id="nombre" class="form-control">
                @error('nombre')
                  <small style="color:red">{{ $message }}</small>
                @enderror
              </div>
              <div class="mb"><br>
                <label for="costo" class="form-label">Costo del Videojuego a agregar</label>
                <input type="number" name="costo" id="costo" class="form-control" step="any" placeholder="00.00">
                @error('costo')
                  <small style="color:red">{{ $message }}</small>
                @enderror
              </div>
              <div class="mb"><br>
                <label for="jugadores" class="form-label">Numero de jugadores del Videojuego</label>
                <input type="number" name="jugadores" id="jugadores" class="form-control" step="1">
                @error('jugadores')
                  <small style="color:red">{{ $message }}</small>
                @enderror
              </div>
              <div class="mb"><br>
                <label for="clasificacion" class="form-label">Tipo de clasificacion del Videojuego a agregar</label>
                <input type="text" name="clasificacion" id="clasificacion" class="form-control">
                @error('clasificacion')
                  <small style="color:red">{{ $message }}</small>
                @enderror
              </div><br>
              <div class="mb">
                <label for="codigo" class="form-label">Codigo del Videojuego</label>
                <input type="text" class="form-control" name="codigo" id="codigo">
                @error('codigo')
                    <small style="color:red">{{ $message }}</small>
                @enderror
                <div id="emailHelp" class="form-text">Asegurate de agregar de manera correcta los datos.</div>
              </div><br>
              {{-- @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif --}}
              <button type="submit" class="btn btn-primary">Agregar Juego</button>
            </form>
            <div>
              <p></p>
            </div>
        </div>
        <div class="col-2">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>
</html>