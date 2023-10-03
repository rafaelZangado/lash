<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Procedimento;
use Carbon\Carbon;

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
            $procedimentoNomes = $procedimentos->pluck('nome', 'id')->toArray();
            $total = $procedimentos->sum('preco');
            $data = $agendamento->data;
            if($agendamento->status == 'return_date'){
              //$data  = $agendamento->return_date;
              $color = "#FFD700";
            } elseif ($agendamento->status === 'cancel_atend'){
                $color = "#FF0000";
            } else {
                $color = "#32CD32";
            }

            if($agendamento->status == 'completo'){
                $color = "#8B8989";
            }
            
            $evento = [
                "id" => $agendamento->id,
                "title" => $agendamento->cliente->nome,
                "start" => $data.'T'. $agendamento->opening_hours,
                'color' =>  $color,
                'contato' =>  $agendamento->cliente->whastapp,
                'procedimentos' => $procedimentoNomes,
                'total' => $total,
            ];
            $eventos[] = $evento;
        }

        return response()->json($eventos);
    }



    public function teste()
    {

        $procedimentosall = Procedimento::all();
        return response()->json($procedimentosall);

    }

    public function checkin($id){
        $checkin = Agendamento::with('procedimento', 'cliente')->find($id);

        $id = Agendamento::pluck('procedimento_key', 'id')->all();
        $procedimentos = Procedimento::all();
        $pro = $procedimentos->pluck('nome', 'id')->all();

        $procedimentosPorId = [];
        foreach ($id as $agendamentoId => $procedimentoKey) {
            $procedimentoIds = explode(',', $procedimentoKey);
            $nomesProcedimentos = $procedimentos->whereIn('id', $procedimentoIds)->pluck('nome')->all();
            $procedimentosPorId[$agendamentoId] = $nomesProcedimentos;
        }

        $config = resolve(ConfiguraController::class);
        $myConfig = $config->rafael();

        $keyproce = explode(',',$checkin->procedimento_key);
        $proce = Procedimento::find($keyproce);
        $proceInfo = $proce->map(function ($procedimento){
            return [
                'nome' => $procedimento->nome,
                'preco' => $procedimento->preco,
            ];
        });
        $total = $proceInfo->sum('preco');


        $return = [
            $checkin,
            $proceInfo->all(),
            $proce,
            $checkin->cliente->nome
        ];
        return view('/checkin', [
            'checkin' => $checkin,
            'procedimentosPorId' => $procedimentosPorId,
            'pro' => $pro,
            'return' => $return,
            'total' => $total,
            'myConfig' => $myConfig
        ]);
    }

    public function background()
    {
        $config = resolve(ConfiguraController::class);
        $myConfig = $config->rafael();

        return view('/blanck', [
            'myConfig' => $myConfig
        ]);
    }

    public function cardDashboard()
    {
        $hoje = Carbon::today();
        $amanha = $hoje->copy()->addDay();
        $umaSemana = $hoje->copy()->addWeek();
        $agendamentosHoje = Agendamento::whereDate('data', $hoje)->count();
        $agendamentosAmanha = Agendamento::whereDate('data', $amanha)->count();
        $agendamentosUmaSemana = Agendamento::whereBetween('data', [$hoje, $umaSemana])->count();

        return  [
            'agendamentosHoje' => $agendamentosHoje,
            'agendamentosAmanha' => $agendamentosAmanha,
            'agendamentosUmaSemana' => $agendamentosUmaSemana
        ];
    }

}
