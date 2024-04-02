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
        return view('departamentos.new');
    }

    public function store(Request $request)
    {
       // Validación
    $request->validate([
        'name' => 'required|string|max:255',
        'country_code' => 'required|string|max:255', 
    ]);

    // Crearenbd
    Departamento::create([
        'depa_nomb' => $request->name,
        'pais_codi' => $request->country_code,
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
