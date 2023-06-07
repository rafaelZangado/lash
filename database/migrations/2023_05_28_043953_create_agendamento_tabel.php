<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentoTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); // Coluna para armazenar o ID do cliente
            $table->unsignedBigInteger('procedimento_id'); // Coluna para armazenar o ID do procedimento
            //$table->unsignedBigInteger('procedimento_key_id')->nullable();
            $table->date('data');
            $table->string('whastapp');
            $table->timestamps();        

            // $table->foreign('procedimento_key_id')
            //     ->references('id')
            //     ->on('procedimento_key');

            //relacionamento com tabela Procedimentos
            $table->foreign('procedimento_id')
                ->references('id')
                ->on('procedimentos');
            
            //relacionamento com tabela Clientes
            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes'); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
}
