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
    public function index()
    {
        $procedimentos = Procedimento::all();
        $clientes = Cliente::all();

        $agendamentos = Agendamento::with('procedimento', 'cliente')->get();

        $agendamentos->map(function ($agendamento) {
            $agendamento->data = date('d/m/Y', strtotime($agendamento->data));            
            return $agendamento;
        });


        return view('agendamento', [
            'procedimentos' => $procedimentos,
            'clientes' => $clientes,
            'agendamentos' => $agendamentos
        ]);
    }

    public function store(Request $request)
    {

        $dados = $request->validate([
            'procedimento_id' => 'required|array|exists:procedimentos,id',            
            'cliente_id' => 'required',
            'date' => 'required|date',
            'whastapp' => 'required|numeric',
            'opening_hours' => 'required',
           
        ]);
       
        $table = resolve(Agendamento::class);
       
        $table->data = $dados['date'];
        $table->procedimento_id = $dados['procedimento_id'];
        $table->cliente_id = $dados['cliente_id'];
        $table->whastapp = $dados['whastapp'];
        $table->opening_hours = $dados['opening_hours'];
        $table->status = 0;
        $table->final_time = null;
        $table->return_date = null;
        $table->save();
        
        return redirect()->route('agendamento')->with('success', 'Agendamento atualizado com sucesso.');
    }

    public function update(Request $request, $id)
    {
        $agendamento = Agendamento::find($id);

        $agendamento->data = $request->input('data');
        $agendamento->opening_hours = $request->input('opening_hours');
        $agendamento->procedimento_id = $request->input('procedimento_id');

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
      
       
        
       // $horaAtual = Carbon::parse($agendamento->data);
        $agendamento->final_time = $horaAtual->format('H:i');         
        $agendamento->status = false;
        $agendamento->save();
       
        return redirect()->route('agendamento')->with('success', 'Agendamento atualizado com sucesso.');
    }


    public function delete($id)
    {
        Agendamento::find($id)->delete();
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
