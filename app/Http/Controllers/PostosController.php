<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostosController extends Controller
{
    public function index()
    {
        return view('posto.index');
    }
}
