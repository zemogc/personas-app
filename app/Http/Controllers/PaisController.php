<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pais; //modelo pais imporss

class PaisController extends Controller
{
    public function index()
    {
        $paises = Pais::all();
        return view('paises.index', compact('paises'));
    }

    public function create()
    {
        return view('paises.new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Pais::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('paises.index')->with('success', 'País creado correctamente');
    }

    public function edit(Pais $pais)
    {
        return view('paises.edit', compact('pais'));
    }

    public function update(Request $request, Pais $pais)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $pais->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('paises.index')->with('success', 'País actualizado correctamente');
    }

    public function destroy(Pais $pais)
    {
        $pais->delete();

        return redirect()->route('paises.index')->with('success', 'País eliminado correctamente');
    }
}
