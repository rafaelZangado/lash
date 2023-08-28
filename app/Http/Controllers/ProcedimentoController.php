<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcedimentoRequest;
use App\Models\Procedimento;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProcedimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procedimentos = Procedimento::all();

        return view('/procedimento', ['procedimentos' => $procedimentos]);
    }

    public function store(ProcedimentoRequest $request)
    {
        $dados = $request->validated();

        $table = new Procedimento();

        $table->nome = $dados['nome'];
        $table->descricao = $dados['descricao'];
        $table->preco = $dados['preco'] = Str::replace(['.',',',''], '', $dados['preco']);
        $table->preco = $table->preco /100;
        $table->save();
        return redirect()->back()->with('success', 'Informações registradas com sucesso!');

    }

    public function delet($id)
    {
        if ($id) {
            Procedimento::find($id)->delete();
        }
    }

    public function up(ProcedimentoRequest $request, $id)
    {
        $dados = $request->validated();

        $procedimento = Procedimento::find($id);

        $procedimento->nome = $dados['nome'];
        $procedimento->descricao = $dados['descricao'];
        $precoFormatado = str_replace(['.', ',', ' '], '', $dados['preco']);
        $precoFormatado = floatval($precoFormatado) / 100;
        $procedimento->preco = $precoFormatado;
        $procedimento->save();
        return redirect()->back()->with('success', 'Informações registradas com sucesso!');

    }

}
