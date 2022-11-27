<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('secretarias', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        DB::table('secretarias')->insert([
            'name' => null,
            'logo' => null
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('secretarias');
    }
};
