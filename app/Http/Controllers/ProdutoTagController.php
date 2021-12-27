<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdutoTagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
