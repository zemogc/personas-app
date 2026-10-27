<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaisRequest;
use App\Models\Municipio;
use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    public function index(Request $request)
    {
        $paises = Pais::with('capital')
            ->buscar($request->query('q'))
            ->orderBy('pais_nomb')
            ->paginate(config('geografia.por_pagina'))
            ->withQueryString();

        return view('paises.index', compact('paises'));
    }

    public function create()
    {
        return view('paises.new', ['municipios' => $this->municipios()]);
    }

    public function store(PaisRequest $request)
    {
        Pais::create($request->validated());

        return redirect()->route('paises.index')->with('success', 'País creado correctamente.');
    }

    public function edit(Pais $pais)
    {
        return view('paises.edit', ['pais' => $pais, 'municipios' => $this->municipios()]);
    }

    public function update(PaisRequest $request, Pais $pais)
    {
        $pais->update($request->validated());

        return redirect()->route('paises.index')->with('success', 'País actualizado correctamente.');
    }

    public function destroy(Pais $pais)
    {
        if ($pais->departamentos()->exists()) {
            return redirect()->route('paises.index')
                ->with('error', 'No se puede eliminar el país porque tiene departamentos asociados.');
        }

        $pais->delete();

        return redirect()->route('paises.index')->with('success', 'País eliminado correctamente.');
    }

    private function municipios()
    {
        return Municipio::orderBy('muni_nomb')->get();
    }
}
