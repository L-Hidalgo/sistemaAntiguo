<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartamentosTable extends Migration
{
   
    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('conector')->nullable();
            $table->string('nombre')->nullable();
            $table->unsignedBigInteger('gerencia_id');
            $table->unsignedBigInteger('personal_id');
            $table->foreign('gerencia_id')->references('id')->on('gerencias');
            $table->foreign('personal_id')->references('id')->on('personales');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('departamentos');
    }
};
