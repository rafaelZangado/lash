<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Config;
use App\Models\Procedimento;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ConfiguraController extends Controller
{
    protected $procedimentos;
    protected $config;

    public function __construct(Procedimento $procedimentos, Config $config)
    {
        $this->procedimentos = $procedimentos;
        $this->config = $config;
    }


    public function index()
    {

        $user = '1';
        $myconfig = $this->config->where('id', $user)->first();
      //  dd($myconfig->pre_schedule);
        return view('/configuracao',
        [
            'procedimentos' => $this->procedimentos->all(),
            'myconfig' =>  $myconfig,

        ]);
    }

    public function configreturn(Request $valor)
    {

        $valor =  floatval(str_replace(',', '.', str_replace('.', '', $valor->preco)));

        return ([
            $valor
        ]);
    }


    public function taxagenda(Request $request, Config $confi)
    {
        $taxa = floatval(str_replace(',', '.', str_replace('.', '', $request->preco)));
        $atualizacao = $confi->where('id', 1)->update([
            'pre_schedule' => $taxa,
        ]);

        if ($atualizacao) {
            return 'salvo';
        } else {
            return 'erro';
        }

    }

}
