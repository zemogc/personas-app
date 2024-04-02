<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Departamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Listado de Departamentos</h1>
        <a href="{{ route('departamentos.create') }}" class="btn btn-success">Crear Departamento</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">País</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departamentos as $departamento)
                <tr>
                    <th scope="row">{{ $departamento->depa_codi }}</th>
                    <td>{{ $departamento->depa_nomb }}</td>
                    <td>{{ $departamento->pais_codi }}</td>
                    <td>
                        <a href="{{ route('departamentos.edit', ['departamento' => $departamento->depa_codi]) }}" class="btn btn-info">Editar</a>
                        <form action="{{ route('departamentos.destroy', ['departamento' => $departamento->depa_codi]) }}" method="POST" style="display: inline-block">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
