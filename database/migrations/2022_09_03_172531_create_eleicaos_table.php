<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eleicaos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('start_date_eleicao');
            $table->dateTime('end_date_eleicao');
            $table->dateTime('start_date_inscricao');
            $table->dateTime('end_date_inscricao');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eleicaos');
    }
};
