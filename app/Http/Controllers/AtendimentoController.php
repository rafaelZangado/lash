<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Procedimento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AtendimentoController extends Controller
{
    public function index()
    {
        $procedimentos = Procedimento::all();
        $clientes = Cliente::all();
        $agendamentos = Agendamento::with('procedimento', 'cliente')->get();
        return view('/fullcalendar', 
        [
            'procedimentos' =>  $procedimentos,
            'clientes' => $clientes,
            'agendamentos' => $agendamentos,
        ]);         
     
    }

    public function start($id)
    {
       
        $agendamento = Agendamento::find($id);
        $dataRetur = 15;
        $response = Http::get('http://worldtimeapi.org/api/timezone/America/Sao_Paulo');
        $data = $response->json();
        
        if ($data['datetime']) {
            $horaAtual = Carbon::parse($data['datetime']);
            $horaAtual->format('H:i');   
        }   
        
        $dataInicial = Carbon::parse($agendamento->data);
        $dataFinal = $dataInicial->addDays($dataRetur);
        
        $agendamento->start_time = $horaAtual->format('H:i'); 
        $agendamento->status = true;
        $agendamento->return_date = $dataFinal->toDateString();

        $agendamento->save();
           
    }

    public function delete($id)
    {
       
        if ($id) {
            return true;
           // Agendamento::find($id)->delete();
        }
    }
}
