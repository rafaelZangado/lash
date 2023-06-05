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
        $procedimentos = Procedimento::all();
        $clientes = Cliente::all();

        $agendamentos = Agendamento::with('procedimento', 'cliente')->get();

        return view('atendimento', [
            'procedimentos' => $procedimentos,
            'clientes' => $clientes,
            'agendamentos' => $agendamentos
        ]);
        
    }
}
