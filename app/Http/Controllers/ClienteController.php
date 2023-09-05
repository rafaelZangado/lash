<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('/clientes', ['clientes' => $clientes]);
    }

     /**
     * Delete registro
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function delet($id)
    {
        if ($id) {
            Cliente::find($id)->delete();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request)
    {

       $cliente = new Cliente();
       $dados = $request->validated();
       $cliente->nome = $dados['nome'];
       $cliente->email = $dados['email'];
       $cliente->whastapp = preg_replace('/[^0-9]/', '', $dados['whastapp']);
       $cliente->instagram = $dados['instagram'];
       $cliente->cpf = preg_replace('/[^0-9]/', '', $dados['cpf']);
       $cliente->save();
       return redirect()->back()->with('success', 'Informações registradas com sucesso!');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function up(ClienteRequest $request, $id)
    {
        $cliente = Cliente::find($id);

        $dados = $request->validated();

        $cliente->nome = $dados['nome'];
        $cliente->cpf = $dados['cpf'];
        $cliente->whastapp = $dados['whastapp'];
        $cliente->save();

        if($cliente->save()) {
            return redirect()->back()->with('success', 'ATUALIZAÇÃO FEITA COM SUCESSO.!');
        } else {
            return redirect()->back()->with('error', 'não foi possivel fazer mudanças!');
        }
    }
}
