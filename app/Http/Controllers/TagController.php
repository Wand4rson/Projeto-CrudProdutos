<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    //Somente Usuários Logados Tem Acesso a Este Controller
    public function __construct()
    {
        $this->middleware('auth');
    }

}
