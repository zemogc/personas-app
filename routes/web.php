<?php

use App\Http\Controllers\ComunaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/comunas', [ComunaController::class, 'index'])->name('comunas.index');
Route::post('/comunas',[ComunaController::class, 'store'])->name('comunas.store');
Route::get('/comunas/create', [ComunaController::class,'create'])->name('comunas.create');
