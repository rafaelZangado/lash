<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    
    public function eventos()
    {
       
        $agendamentos = Agendamento::all();

        $eventos = [];
        foreach ($agendamentos as $agendamento) {
            $evento = [
                "title" => $agendamento->nome,
                "start" => $agendamento->data,
            ];
            $eventos[] = $evento;
        }
                
       // return $agendamento;
        return response()->json($eventos);

           
    }

    public function index(){
        $agendamento = Agendamento::all();

        $response = Http::get('http://worldtimeapi.org/api/timezone/America/Sao_Paulo');
        $data = $response->json();
        
       // dd($agendamento);
        
        return view('/dashboard');
    }

    public function teste(){

        $agendamento = Agendamento::all();
        $agendamento =  json_encode($agendamento);
        
        return view('/elementoTeste', [
           'agendamento' => $agendamento
        ]);
    }


}
