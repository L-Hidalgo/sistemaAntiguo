<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('conector')->nullable();
            $table->unsignedBigInteger('gerencia_id');
            $table->foreign('gerencia_id')->references('id')->on('gerencias');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('departamentos');
    }
};
