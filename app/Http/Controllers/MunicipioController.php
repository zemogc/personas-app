<?php

namespace App\Http\Controllers;

use App\Http\Requests\MunicipioRequest;
use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public function index(Request $request)
    {
        $municipios = Municipio::with('departamento')
            ->buscar($request->query('q'))
            ->orderBy('muni_nomb')
            ->paginate(config('geografia.por_pagina'))
            ->withQueryString();

        return view('municipios.index', compact('municipios'));
    }

    public function create()
    {
        return view('municipios.new', ['departamentos' => $this->departamentos()]);
    }

    public function store(MunicipioRequest $request)
    {
        Municipio::create($request->validated());

        return redirect()->route('municipios.index')->with('success', 'Municipio creado correctamente.');
    }

    public function edit(Municipio $municipio)
    {
        return view('municipios.edit', ['municipio' => $municipio, 'departamentos' => $this->departamentos()]);
    }

    public function update(MunicipioRequest $request, Municipio $municipio)
    {
        $municipio->update($request->validated());

        return redirect()->route('municipios.index')->with('success', 'Municipio actualizado correctamente.');
    }

    public function destroy(Municipio $municipio)
    {
        if ($municipio->comunas()->exists()) {
            return redirect()->route('municipios.index')
                ->with('error', 'No se puede eliminar el municipio porque tiene comunas asociados.');
        }

        $municipio->delete();

        return redirect()->route('municipios.index')->with('success', 'Municipio eliminado correctamente.');
    }

    private function departamentos()
    {
        return Departamento::orderBy('depa_nomb')->get();
    }
}
