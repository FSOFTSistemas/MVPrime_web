<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Carbon\Carbon;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $home_service)
    {
        $this->homeService = $home_service;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Carbon::setLocale('pt_BR');

        $dadosDias = collect($this->homeService->listarAbastecimentosDia());
        $diaLabels = $dadosDias->pluck('dia')->map(function ($dia) {
            return \Carbon\Carbon::parse($dia)->translatedFormat('d');
        })->toArray();
        $diaData = $dadosDias->pluck('total_valor')->toArray();


        $dadosMes = collect($this->homeService->listarAbastecimentosMes());
        $mesLabels = $dadosMes->pluck('mes')->map(function ($mes) {
            return \Carbon\Carbon::parse($mes)->translatedFormat('M-Y');
        })->toArray();
        $mesData = $dadosMes->pluck('total_valor')->toArray();
        
        
        $dadosPrefeitura = $this->homeService->listarAbastecimentosPrefeitura();

        return view('home', compact('mesLabels', 'mesData', 'diaLabels', 'diaData', 'dadosPrefeitura'));
    }
}
