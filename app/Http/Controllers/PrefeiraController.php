<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrefeiraController extends Controller
{
    public function index()
    {
        return view('prefeira.index');
    }
}
