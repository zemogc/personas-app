<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class municipio extends Controller
{
    public function index()
    {
        $municipios = Municipio::all();
        return view('municipios.index', compact('municipios'));
    }

    public function create()
    {
        return view('municipios.create');
    }

    public function store(Request $request)
    {
        // Validación y almacenamiento de un nuevo municipio
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
