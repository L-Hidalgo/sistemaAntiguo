<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGerenciasTable extends Migration
{
    
    public function up()
    {
        Schema::create('gerencias', function (Blueprint $table) {
            $table->id();
            $table->string('conector')->nullable();
            $table->string('nombre')->nullable();
            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->timestamps();
        });   
    }

    public function down()
    {
        Schema::dropIfExists('gerencias');
    }
};
