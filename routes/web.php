<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PrefeiraController;
use App\Http\Controllers\SecretariasController;
use App\Http\Controllers\MotoristasController;
use App\Http\Controllers\VeiculosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PostosController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AbastecimentosController;


Route::get('/', function () {
    return view('welcome'); // Exibe a tela inicial padrão do Laravel
})->name('home');

Route::get('/login', function () {
    return view('auth.login'); // Exibe a tela de login
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::middleware('jwt.auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Exibe o dashboard após login
    })->name('dashboard');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::resource('empresa', [EmpresaController::class])->middleware('auth');
Route::resource('prefeira', [PrefeiraController::class])->middleware('auth');
Route::resource('secretarias', [SecretariasController::class])->middleware('auth');
Route::resource('motoristas', [MotoristasController::class])->middleware('auth');
Route::resource('veiculos', [VeiculosController::class])->middleware('auth');
Route::resource('usuarios', [UsuariosController::class])->middleware('auth');
Route::resource('postos', [PostosController::class])->middleware('auth');
Route::resource('log', [LogController::class])->middleware('auth');
Route::resource('abastecimentos', [AbastecimentosController::class])->middleware('auth');
