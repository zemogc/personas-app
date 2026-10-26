<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComunaRequest;
use App\Models\Comuna;
use App\Models\Municipio;

class ComunaController extends Controller
{
    public function index()
    {
        $comunas = Comuna::with('municipio')->orderBy('comu_nomb')->get();

        return view('comunas.index', compact('comunas'));
    }

    public function create()
    {
        return view('comunas.new', ['municipios' => $this->municipios()]);
    }

    public function store(ComunaRequest $request)
    {
        Comuna::create($request->validated());

        return redirect()->route('comunas.index')->with('success', 'Comuna creada correctamente.');
    }

    public function edit(Comuna $comuna)
    {
        return view('comunas.edit', ['comuna' => $comuna, 'municipios' => $this->municipios()]);
    }

    public function update(ComunaRequest $request, Comuna $comuna)
    {
        $comuna->update($request->validated());

        return redirect()->route('comunas.index')->with('success', 'Comuna actualizada correctamente.');
    }

    public function destroy(Comuna $comuna)
    {
        $comuna->delete();

        return redirect()->route('comunas.index')->with('success', 'Comuna eliminada correctamente.');
    }

    private function municipios()
    {
        return Municipio::orderBy('muni_nomb')->get();
    }
}
