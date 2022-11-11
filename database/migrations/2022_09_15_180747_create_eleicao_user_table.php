<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEleicaoUserTable extends Migration
{
    public function up()
    {
        Schema::create('eleicao_user', function (Blueprint $table) {
            $table->unsignedBigInteger('eleicao_id');
            $table->unsignedBigInteger('user_id');

            // LIDANDO COM A ELEIÇÃO
            $table->string('categoria'); //CANDIDATO OU ELEITOR
            $table->string('ocupacao');
            $table->boolean('votacao_status')->default(false); //STATUS DA VOTACAO
            $table->integer('voto')->default(0); // QTD_VOTO
            $table->datetime('voto_datetime')->nullable();

            // LIDANDO COM DOCUMENTO
            $table->string('doc_user')->nullable(); // DOCUMENTO DO USUARIO PARA ESPECIFICA ELEIÇÃO
            $table->string('doc_user_status')->default('pendente'); // STATUS APROVAÇÃO DO DOCUMENTO ( PENDENTE, APROVADO, NEGADO)
            $table->string('doc_user_message')->nullable();



            $table->primary(['eleicao_id', 'user_id']);
            $table->foreign('eleicao_id')->references('id')->on('eleicaos');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('eleicao_user');
    }
};
