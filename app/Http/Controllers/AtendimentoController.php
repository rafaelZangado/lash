<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Procedimento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AtendimentoController extends Controller
{
    public function index()
    {
        $procedimentos = Procedimento::all();
        $clientes = Cliente::all();
        $agendamentos = Agendamento::with('procedimento', 'cliente')->get();

        $id = Agendamento::pluck('procedimento_key', 'id')->all();
        $procedimentosPorId = [];
        $procedimentos->pluck('nome', 'preco')->toArray();

        foreach ($id as $agendamentoId => $procedimentoKey) {
            $procedimentoIds = explode(',', $procedimentoKey);
            $nomesProcedimentos = $procedimentos->whereIn('id', $procedimentoIds)->pluck('nome')->all();
            $procedimentosPorId[$agendamentoId] = $nomesProcedimentos;
        }
        $pro = $procedimentos->pluck('nome', 'id')->all();

        return view('/fullcalendar',
        [
            'procedimentos' =>  $procedimentos,
            'clientes' => $clientes,
            'agendamentos' => $agendamentos,
            'procedimentosPorId' => $procedimentosPorId,
            'pro' => $pro,
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
        $agendamento->status = 'rescheduled';
        $agendamento->return_date = $dataFinal->toDateString();

        $agendamento->save();

    }

    public function up(Request $request)
    {
        $agendamento = Agendamento::find($request->id);

        $agendamento->status = 'completo';
        $agendamento->payment = $request->input('payment');
        $procedimentosSelecionados = $request->input('procedimento_key');
        $procedimentosIds = implode(',', $procedimentosSelecionados);
        $agendamento->procedimento_key = $procedimentosIds;
        $agendamento->save();

    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'date' => 'required|date',
            'opening_hours' => 'required',
            'cpf' => 'required',
            'nome' => 'required',
            'whatsapp' => 'required',
            'procedimento_key' => 'required|array',
        ]);

        $dados['cpf'] = Str::replace(['.', '-'], '', $dados['cpf']);
        $dados['whatsapp'] = Str::replace(['(', ')', '-'], '', $dados['whatsapp']);

        $this->registeragenda($dados );

        return redirect()->route('atendimento')->with('success', 'Agendamento atualizado com sucesso.');
    }

    public function registercliantes($dados)
    {
        $table_cliente = resolve(Cliente::class);

        $table_cliente->nome = $dados['nome'];
        $table_cliente->whastapp = $dados['whatsapp'];
        $table_cliente->cpf = $dados['cpf'];
        $table_cliente->email = '';
        $table_cliente->instagram = '';

        if($table_cliente->save()) {
            return $id_cliente = $table_cliente->id;
        } else {
            return redirect()->route('agendamento')->with('error', 'Processo não autorizado.');
        }

    }

    public function registeragenda($dados)
    {

        $table_agendamento = resolve(Agendamento::class);
        $id_cliente = $this->registercliantes($dados);
        $table_agendamento->data = $dados['date'];
        $table_agendamento->opening_hours = $dados['opening_hours'];
        $table_agendamento->procedimento_key = implode(',', $dados['procedimento_key']);
        $table_agendamento->cliente_id = $id_cliente;
        $table_agendamento->procedimento_id = 1;
        $table_agendamento->status = 0;
        $table_agendamento->final_time = null;
        $table_agendamento->return_date = null;
        $table_agendamento->whastapp = '';
        $table_agendamento->save();
    }

    public function cancel($id)
    {
        $agendamento = Agendamento::find($id);
        $agendamento->status = 'cancel_atend';
        $agendamento->save();
    }

    public function delete($id)
    {

        if ($id) {
            Agendamento::find($id)->delete();
        }
    }

    public function checkout(Request $request)
    {
        dd( $request->all());
    }
}
