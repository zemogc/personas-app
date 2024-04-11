<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Municipio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Crear Municipio</h1>
        <form method="POST" action="{{ route('municipios.store') }}">
            @csrf
            <div class="mb-3">
                <label for="code" class="form-label">Código del Municipio</label>
                <input type="text" class="form-control" id="code" name="code" placeholder="Código del municipio">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Municipio</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name" placeholder="Nombre del municipio">
            </div>
            <div class="mb-3">
                <label for="municipality">Municipio:</label>
                <select class="form-select" id="municipality" name="municipality_code" required>
                    <option selected disabled value="">Elija uno...</option>
                    @foreach ($municipios as $m)
                   <option value="{{ $m->muni_codi }}">{{ $m->muni_nomb }}</option>
                    @endforeach

                </select>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('municipios.index') }}" class="btn btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>