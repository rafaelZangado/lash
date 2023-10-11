<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtendimentoRequest;
use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Procedimento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AtendimentoController extends Controller
{
    protected $agendamento;
    protected $cliente;

    public function __construct(
        Agendamento $agendamento,
        Cliente $cliente,
    ) {
        $this->agendamento = $agendamento;
        $this->cliente = $cliente;
    }
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

        return view(
            '/fullcalendar',
            [
                'procedimentos' =>  $procedimentos,
                'clientes' => $clientes,
                'agendamentos' => $agendamentos,
                'procedimentosPorId' => $procedimentosPorId,
                'pro' => $pro,
            ]
        );
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
        $cliente_id = $request->id;

        $agendamento = Agendamento::where('cliente_id', $cliente_id)->first();
        $agendamento->status = 'completo';
        $agendamento->payment = $request->input('payment');
        $procedimentosSelecionados = $request->input('procedimento_key');
        $procedimentosIds = implode(',', $procedimentosSelecionados);
        $agendamento->procedimento_key = $procedimentosIds;
        $agendamento->comment = $request->input('comment') ? $request->input('comment') : '';
        $agendamento->save();
    }

    public function store(AtendimentoRequest $request)
    {
        $dados = $request->validated();
        if (!isset($dados['cpf'])) {
            $dados['cpf'] = '';
        } else {
            $dados['cpf'] = Str::replace(['.', '-'], '', $dados['cpf']);
        }
        $dados['whastapp'] = Str::replace(['(', ')', '-'], '', $dados['whastapp']);

        $this->registeragenda($dados);
        return redirect()->back()->with('success', 'Informações registradas com sucesso!');

        //return redirect()->route('atendimento')->with('success', 'Agendamento atualizado com sucesso.');
    }

    public function registercliantes($dados)
    {
        $this->cliente->nome = $dados['nome'];
        $this->cliente->whastapp = $dados['whastapp'];
        $this->cliente->cpf = $dados['cpf'];
        $this->cliente->email = '';
        $this->cliente->instagram = '';

        if ($this->cliente->save()) {
            return $id_cliente = $this->cliente->id;
        } else {
            return redirect()->route('agendamento')->with('error', 'Processo não autorizado.');
        }
    }

    public function registeragenda($dados)
    {
        $id_cliente = $this->registercliantes($dados);

        $agenda = $this->buscarCliente($dados['cpf']);

        $this->agendamento->status = $agenda ? 'return_date' : 0;
        $this->agendamento->data = $dados['date'];
        $this->agendamento->opening_hours = $dados['opening_hours'];
        $this->agendamento->procedimento_key = implode(',', $dados['procedimento_key']);
        $this->agendamento->cliente_id = $id_cliente;
        $this->agendamento->procedimento_id = 1;
        $this->agendamento->final_time = null;
        $this->agendamento->return_date = null;       
        $this->agendamento->comment = '';       
        $this->agendamento->whastapp = '';
        $this->agendamento->payment = '';
        $this->agendamento->save();
    }

    public function cancel($id)
    {
        $agendamento = $this->agendamento->find($id);
        $agendamento->status = 'cancel_atend';
        $agendamento->save();
    }

    public function delete($id)
    {
        if ($id) {
            $this->agendamento->find($id)->delete();
        }
    }

    public function buscarCliente($cpf)
    {

        $agenda = Agendamento::whereHas('cliente', function ($query) use ($cpf) {
            $query->where('cpf', $cpf);
        })->latest()
            ->first();

        if (!$agenda || !$cpf) {
            //return response()->json(['message' => 'Nenhum agendamento encontrado para este CPF'], null);
            return null;
        }

        return  [
            'id' => $agenda->cliente->id,
            'nome' => $agenda->cliente->nome,
            'whastapp' => $agenda->cliente->whastapp,
            'procedimentos' => explode(',', $agenda->procedimento_key),
            'data' => $agenda->data
        ];
    }
}
