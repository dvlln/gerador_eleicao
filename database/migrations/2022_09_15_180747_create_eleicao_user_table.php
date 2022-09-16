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
            $table->string('categoria');
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
