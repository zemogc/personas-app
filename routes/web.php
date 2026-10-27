<?php

use App\Http\Controllers\ComunaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by bootstrap/app.php and all of them will be
| assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    $geografia = [
        'paises' => PaisController::class,
        'departamentos' => DepartamentoController::class,
        'municipios' => MunicipioController::class,
        'comunas' => ComunaController::class,
    ];

    foreach ($geografia as $recurso => $controlador) {
        // Laravel singulariza "paises" como "paise"; se fija el parámetro a {pais}.
        Route::resource($recurso, $controlador)
            ->parameters(['paises' => 'pais'])
            ->only('index');

        Route::resource($recurso, $controlador)
            ->parameters(['paises' => 'pais'])
            ->except(['index', 'show'])
            ->middleware('can:gestionar-geografia');
    }
});

require __DIR__.'/auth.php';
