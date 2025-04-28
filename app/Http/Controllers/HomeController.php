<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomeService;

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
        $dados = $this->homeService->listarAbastecimentos();

        return view('home');
    }
}
