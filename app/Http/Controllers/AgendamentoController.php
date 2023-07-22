<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Procedimento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;


class AgendamentoController extends Controller
{
    protected $table_agendamento;

    public function __construct(Agendamento $table_agendamento)
    {
        $this->table_agendamento = $table_agendamento;
    }

    public function index()
    {
        $procedimentos = Procedimento::all();
        $clientes = Cliente::all();

        $agendamentos = Agendamento::with('procedimento', 'cliente')->get();

        $id = Agendamento::pluck('procedimento_key', 'id')->all();


        $procedimentosPorId = [];

        foreach ($id as $agendamentoId => $procedimentoKey) {
            $procedimentoIds = explode(',', $procedimentoKey);
            $nomesProcedimentos = $procedimentos->whereIn('id', $procedimentoIds)->pluck('nome')->all();
            $procedimentosPorId[$agendamentoId] = $nomesProcedimentos;
        }

        $agendamentos->map(function ($agendamento) {
            $agendamento->data = date('d/m/Y', strtotime($agendamento->data));

            return $agendamento;
        });


        return view('agendamento', [
            'procedimentos' => $procedimentos,
            'clientes' => $clientes,
            'agendamentos' => $agendamentos,
            'procedimentosPorId' => $procedimentosPorId,

        ]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'date' => 'required|date',
            'opening_hours' => 'required',
            'cpf' => 'required',
            'nome' => 'required',
            'whatsapp' => 'required|numeric',
            'processo' => 'required|array',
        ]);

        $this->registeragenda($dados );

        return redirect()->route('agendamento')->with('success', 'Agendamento atualizado com sucesso.');
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
        $table_agendamento->procedimento_key = implode(',', $dados['processo']);
        $table_agendamento->cliente_id = $id_cliente;
        $table_agendamento->procedimento_id = 1;
        $table_agendamento->status = 0;
        $table_agendamento->final_time = null;
        $table_agendamento->return_date = null;
        $table_agendamento->whastapp = '';
        $table_agendamento->save();
    }

    public function update(Request $request, $id)
    {
        $agendamento = Agendamento::find($id);

        $agendamento->data = $request->input('data');
        $agendamento->opening_hours = $request->input('opening_hours');
        $procedimentosSelecionados = $request->input('procedimento_key');
        $procedimentosIds = implode(',', $procedimentosSelecionados);
        $agendamento->procedimento_key = $procedimentosIds;
        $agendamento->save();

        return redirect()->route('agendamento')->with('success', 'Agendamento atualizado com sucesso.');
    }

    public function start(Request $request, $id)
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
        return redirect()->route('agendamento')->with('success', 'Agendamento atualizado com sucesso.');
    }

    public function close(Request $request, $id)
    {
        $agendamento = Agendamento::find($id);
        $response = Http::get('http://worldtimeapi.org/api/timezone/America/Sao_Paulo');
        $data = $response->json();

        $horaAtual = Carbon::parse($data['datetime']);
        $horaAtual->format('H:i');

        $agendamento->final_time = $horaAtual->format('H:i');
        $agendamento->status = false;
        $agendamento->save();

        return redirect()->route('agendamento')->with('success', 'Agendamento atualizado com sucesso.');
    }


    public function delete($id)
    {
        if ($id) {
            Agendamento::find($id)->delete();
            return redirect()->back()->with('success', 'Informações registradas com sucesso!');
        }

        return redirect()->back()->with('success', 'Informações registradas com sucesso!');

    }


    public function filtrar(Request $request)
    {
        $filtro = $request->input('filtro');

        if ($filtro === 'ultimos_dias') {
          $dias = $request->input('dias');
          $agendamentos = Agendamento::where('data', '>=', Carbon::now()->subDays($dias))->get();
        } elseif ($filtro === 'ultimas_semanas') {
          $semanas = $request->input('semanas');
          $agendamentos = Agendamento::where('data', '>=', Carbon::now()->subWeeks($semanas))->get();
        } elseif ($filtro === 'data') {
          $data = $request->input('data');
          $agendamentos = Agendamento::where('data', $data)->get();
        } else {
          $agendamentos = Agendamento::all();
        }
        dd( $filtro);
        return view('agendamento', ['agendamentos' => $agendamentos]);
    }
}
