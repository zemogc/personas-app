<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;


class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::all();
        return view('departamentos.index', compact('departamentos'));
    }
    public function create()
    {
        return view('departamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'depa_nomb' => 'required|string|max:255',
            'pais_codi' => 'required|exists:paises,pais_codi'
        ]);

        Departamento::create([
            'depa_nomb' => $request->depa_nomb,
            'pais_codi' => $request->pais_codi
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado correctamente');
    }

    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        $request->validate([
            'depa_nomb' => 'required|string|max:255',
            'pais_codi' => 'required|exists:paises,pais_codi'
        ]);

        $departamento->update([
            'depa_nomb' => $request->depa_nomb,
            'pais_codi' => $request->pais_codi
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado correctamente');
    }

    public function destroy(Departamento $departamento)
    {
        $departamento->delete();
        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado correctamente');
    }
}
