<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Relatorio extends Controller
{
    public function abastecimentoPorData()
    {
        return view('rel.abastecimento');
    }
}
