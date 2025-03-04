<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbastecimentosController extends Controller
{
    public function index()
    {
        return view('abastecimento.index');
    }
}
