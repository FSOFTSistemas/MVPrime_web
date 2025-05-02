<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PrefeituraController;
use App\Http\Controllers\SecretariasController;
use App\Http\Controllers\MotoristasController;
use App\Http\Controllers\VeiculosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PostosController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AbastecimentosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Relatorio;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.custom');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('home', [HomeController::class, 'index'])->name('home');


Route::resource('empresas', EmpresaController::class)->middleware('auth');
Route::resource('prefeituras', PrefeituraController::class)->middleware('auth');
Route::resource('secretarias', SecretariasController::class)->middleware('auth');
Route::resource('motoristas', MotoristasController::class)->middleware('auth');
Route::resource('veiculos', VeiculosController::class)->middleware('auth');
Route::resource('usuarios', UsuariosController::class)->middleware('auth');
Route::resource('postos', PostosController::class)->middleware('auth');
Route::resource('log', LogController::class)->middleware('auth');
Route::resource('abastecimentos', AbastecimentosController::class)->middleware('auth');
Route::get('/enderecos', [EnderecoController::class, 'listarEnderecos'])->name('enderecos.index');
Route::resource('enderecos', EnderecoController::class)->middleware('auth');
Route::post('/filtro-prefeitura', [PrefeituraController::class, 'filtroPrefeitura'])->name('filtro.prefeitura')->middleware('auth');
Route::get('/rel-abastecimento-data', [Relatorio::class, 'abastecimentoPorData'])->middleware('auth');

