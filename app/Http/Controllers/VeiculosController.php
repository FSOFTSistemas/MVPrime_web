<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VeiculosController extends Controller
{
    public function index()
    {
        return view('veiculo.index');
    }
}
