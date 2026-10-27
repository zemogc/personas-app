<?php

namespace App\Http\Controllers;

use App\Models\Comuna;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Pais;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $totales = [
            'paises' => Pais::count(),
            'departamentos' => Departamento::count(),
            'municipios' => Municipio::count(),
            'comunas' => Comuna::count(),
        ];

        $departamentosDestacados = Departamento::with('pais')
            ->withCount('municipios')
            ->orderByDesc('municipios_count')
            ->orderBy('depa_nomb')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'usuario' => $request->user(),
            'totales' => $totales,
            'departamentosDestacados' => $departamentosDestacados,
        ]);
    }
}
