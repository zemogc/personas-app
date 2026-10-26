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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
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

    // Laravel singulariza "paises" como "paise"; se fija el parámetro a {pais}.
    Route::resource('paises', PaisController::class)
        ->parameters(['paises' => 'pais'])
        ->except('show');
    Route::resource('departamentos', DepartamentoController::class)->except('show');
    Route::resource('municipios', MunicipioController::class)->except('show');
    Route::resource('comunas', ComunaController::class)->except('show');
});

require __DIR__.'/auth.php';
