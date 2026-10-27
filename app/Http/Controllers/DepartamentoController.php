<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartamentoRequest;
use App\Models\Departamento;
use App\Models\Pais;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index(Request $request)
    {
        $departamentos = Departamento::with('pais')
            ->buscar($request->query('q'))
            ->orderBy('depa_nomb')
            ->paginate(config('geografia.por_pagina'))
            ->withQueryString();

        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.new', ['paises' => $this->paises()]);
    }

    public function store(DepartamentoRequest $request)
    {
        Departamento::create($request->validated());

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado correctamente.');
    }

    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', ['departamento' => $departamento, 'paises' => $this->paises()]);
    }

    public function update(DepartamentoRequest $request, Departamento $departamento)
    {
        $departamento->update($request->validated());

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado correctamente.');
    }

    public function destroy(Departamento $departamento)
    {
        if ($departamento->municipios()->exists()) {
            return redirect()->route('departamentos.index')
                ->with('error', 'No se puede eliminar el departamento porque tiene municipios asociados.');
        }

        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado correctamente.');
    }

    private function paises()
    {
        return Pais::orderBy('pais_nomb')->get();
    }
}
