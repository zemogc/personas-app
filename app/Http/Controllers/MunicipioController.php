<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipio; // Importar el modelo Municipio

class MunicipioController extends Controller
{
    public function index()
    {
        $municipios = Municipio::all();
        return view('municipios.index', compact('municipios'));
    }

    public function create()
    {
        return view('municipios.new', compact('municipios'));
    }

    public function store(Request $request)
    {
        // Validación y almacenamiento de un nuevo municipio es decir la creacion
         // Validación de los datos del formulario
         $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|exists:tb_municipio,muni_codi'
        ]);

        // Crear una nueva instancia de Municipio con los datos del formulario
        $municipio = new Municipio();
        $municipio->muni_nomb = $request->name;
        $municipio->muni_codi = $request->code;
        $municipio->depa_codi = 10;
        
        // Guardar el nuevo municipio en la base de datos
        $municipio->save();

        // Redirigir a la vista index con un mensaje de éxito
        return redirect()->route('municipios.index')->with('success', 'Municipio creado correctamente');
    
    }

    public function show(Municipio $municipio)
    {
        return view('municipios.show', compact('municipio'));
    }

    public function edit(Municipio $municipio)
    {
        return view('municipios.edit', compact('municipio'));
    }

    public function update(Request $request, Municipio $municipio)
    {
        // Validación y actualización de un municipio existente
    }

    public function destroy(Municipio $municipio)
    {
        // Eliminación de un municipio existente
    }
}
