<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Procedimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    
    public function eventos()
    {
       
        $agendamentos = Agendamento::with('cliente', 'procedimento')->get();
        
        $eventos = [];
        $procedimentos = [];
        foreach ($agendamentos as $agendamento) {

            $procedimentoIds = explode(',', $agendamento->procedimento_key);
            $procedimentoIds = array_map('trim', $procedimentoIds);
            $procedimentos = Procedimento::whereIn('id', $procedimentoIds)->get();
            $procedimentoNomes = $procedimentos->pluck('nome')->toArray();
            $total = $procedimentos->sum('preco');
           
            $evento = [
                "id" => $agendamento->id,
                "title" => $agendamento->cliente->nome,
                "start" => $agendamento->data.'T'. $agendamento->opening_hours,
                'color' => '#32CD32',
                'contato' =>  $agendamento->cliente->whastapp,
                'procedimentos' => $procedimentoNomes,
                'total' => $total/100
            ];
            $eventos[] = $evento;
        }       
       
        return response()->json($eventos);   
    }

    public function index(){        
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
