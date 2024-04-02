<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar País</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Editar País</h1>
        <form method="POST" action="{{ route('paises.update', ['pais' => $pais->id]) }}">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del País</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $pais->nombre }}">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('paises.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
