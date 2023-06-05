<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(){
        $agendamento = Agendamento::all();

        $response = Http::get('http://worldtimeapi.org/api/timezone/America/Sao_Paulo');
        $data = $response->json();
        
       // dd($agendamento);
        
        return view('/dashboard');
    }

    public function teste(){
     
           
        return view('/elementoTeste');
    }
}
