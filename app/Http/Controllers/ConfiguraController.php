<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguraController extends Controller
{
    public function index()
    {
        return view('/configuracao');
    }
}
