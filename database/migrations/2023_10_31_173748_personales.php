<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalesTable extends Migration
{
    
    public function up()
    {
        Schema::create('personales', function (Blueprint $table) {
            $table->id();
            $table->string('ci')->unique();
            $table->string('an');
            $table->string('exp');
            $table->string('paterno')->nullable();
            $table->string('materno')->nullable();
            $table->string('nombre')->nullable();
            $table->string('nombreApellido')->nullable();
            $table->string('carreraIrregular')->nullable();
            $table->string('formacion')->nullable();
            $table->string('sexo')->nullable();
            $table->timestamp('fechaNacimiento');
            $table->unsignedBigInteger('puesto_id');
            $table->unsignedBigInteger('integracionDePersonal_id');
            $table->unsignedBigInteger('procesoDeIncorporacion_id');
            $table->unsignedBigInteger('procesoDeDesvinculacion_id');
            $table->foreign('puesto_id')->references('id')->on('puestos');
            $table->foreign('integracionDePersonal_id')->references('id')->on('integracionDePersonales');
            $table->foreign('procesoDeIncorporacion_id')->references('id')->on('procesoDeIncorporaciones');
            $table->foreign('procesoDeDesvinculacion_id')->references('id')->on('procesoDeDesvinculaciones');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personales');
    }
};
