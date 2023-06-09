<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Procedimento;
use Illuminate\Http\Request;

class AtendimentoController extends Controller
{
    public function index()
    {
        return view('/fullcalendar');         
     
    }

    public function eventos()
    {
       
        $agendamentos = Agendamento::with('cliente')->get();
        
        $eventos = [];
        foreach ($agendamentos as $agendamento) {
            $evento = [
                "title" => $agendamento->cliente->nome,
                "start" => $agendamento->data,
            ];
            $eventos[] = $evento;
        }
                
       // return $agendamento;
        return response()->json($eventos);

           
    }
}
