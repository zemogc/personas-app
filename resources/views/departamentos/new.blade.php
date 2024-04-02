<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Departamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Crear Departamento</h1>
        <form method="POST" action="{{ route('departamentos.store') }}">
            @csrf
            <div class="mb-3">
                <label for="id" class="form-label">Código</label>
                <input type="text" class="form-control" id="id" aria-describedby="idHelp" name="id" disabled="disabled">
                <div id="idHelp" class="form-text">Código del departamento</div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Departamento</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name" placeholder="Nombre del departamento">
            </div>
            <div class="mb-3">
                <label for="country_code" class="form-label">Código del País</label>
                <input type="text" class="form-control" id="country_code" aria-describedby="countryCodeHelp" name="country_code" placeholder="Código del país">
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('departamentos.index') }}" class="btn btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
