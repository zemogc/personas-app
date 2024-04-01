<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Crear Municipio</title>
</head>
<body>
<div class="container">
    <h1>Crear Municipio</h1>
    <form method="POST" action="{{ route('municipios.store') }}">
        @csrf
        <div class="mb-3">
            <label for="id" class="form-label">Código</label>
            <input type="text" class="form-control" id="id" aria-describedby="idHelp" name="id" disabled="disabled">
            <div id="idHelp" class="form-text">Código del municipio</div>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Municipio</label>
            <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name" placeholder="Nombre del municipio">
        </div>
        <div class="mb-3">
            <label for="municipality">Municipio:</label>
            <select class="form-select" id="municipality" name="code" required>
                <option selected disabled value="">Elija uno...</option>
                @foreach ($municipios as $municipio)
                    <option value="{{ $municipio->muni_codi }}">{{ $municipio->muni_nomb }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('municipios.index') }}" class="btn btn-warning">Cancelar</a>
        </div>
    </form>
</div>

<!-- Optional JavaScript; choose one of the two! -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
