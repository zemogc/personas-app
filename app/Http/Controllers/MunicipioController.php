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
       
        $municipios = Municipio::all();
        return view('municipios.new', compact('municipios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'muni_codi' => 'required|exists:tb_municipio,muni_codi'
        ]);
        
        $municipio = new Municipio();
        $municipio->muni_nomb = $request->name;
        $municipio->muni_codi = $request->muni_codi;
        $municipio->depa_codi = 10; 
        
        $municipio->save();
    
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
        // configuo la actualizacion ya que va de la mano con el edit de arriba
        // datos y vaidaciones
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|exists:tb_municipio,muni_codi'
        ]);

        // actualizacion
        $municipio->update([
            'muni_nomb' => $request->name,
            'muni_codi' => $request->code
        ]);

        // mensaje de aactualizado con éxito
        return redirect()->route('municipios.index')->with('success', 'Municipio actualizado correctamente');
    
    }

    public function destroy(Municipio $municipio)
    {
  // Verificar si el municipio existe en bd
  if ($municipio) {
    // Eliminar el municipio de la base de datos
    $municipio->delete();

    // Redirigir de vuelta a la vista index con un mensaje de éxito
    return redirect()->route('municipios.index')->with('success', 'Municipio eliminado correctamente');
} else {
    // Si el municipio no existe, redirigir con un mensaje de error
    return redirect()->route('municipios.index')->with('error', 'El municipio no existe o ya ha sido eliminado');
}
    }
}