<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Municipio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Editar Municipio</h1>
        <form method="POST" action="{{ route('municipios.update', ['municipio' => $municipio->muni_codi]) }}">
        @method('put')
    @csrf
            <div class="mb-3">
            <label for="name" class="form-label">Nombre del Municipio</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ $municipio->muni_nomb }}">
        </div>

        <div class="mb-3">
                <label for="code" class="form-label">Código del Municipio</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ $municipio->muni_codi }}">
            </div>


            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('municipios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
