<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    
    public function eventos()
    {
       
        $agendamentos = Agendamento::with('cliente')->get();

        $eventos = [];
        foreach ($agendamentos as $agendamento) {
            $evento = [
                "title" => $agendamento->cliente->nome,
                "start" => $agendamento->data.'T'. $agendamento->opening_hours,
                'color' => '#32CD32',
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
        resolve(App\Http\Controllers\AgendamentoController::class);
        
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
