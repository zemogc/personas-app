<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Departamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Editar Departamento</h1>
        <form method="POST" action="{{ route('departamentos.update', ['departamento' => $departamento->depa_codi]) }}">
    @method('PUT')
    @csrf
    <div class="mb-3">
        <label for="depa_nomb" class="form-label">Nombre del Departamento</label>
        <input type="text" class="form-control" id="depa_nomb" name="depa_nomb" value="{{ $departamento->depa_nomb }}">
    </div>
    <div class="mb-3">
        <label for="pais_codi" class="form-label">Código del País</label>
        <input type="text" class="form-control" id="pais_codi" name="pais_codi" value="{{ $departamento->pais_codi }}">
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('departamentos.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
