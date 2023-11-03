<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('personales', function (Blueprint $table) {
            $table->id();
            $table->string('ci')->unique();
            $table->string('an')->nullable();
            $table->string('exp')->nullable();
            $table->string('paterno')->nullable();
            $table->string('materno')->nullable();
            $table->string('nombre')->nullable();
            $table->string('nombreApellido')->nullable();
            $table->string('carreraIrregular')->nullable();
            $table->string('formacion')->nullable();
            $table->string('sexo')->nullable();
            $table->string('fechaNacimiento')->nullable();
            // Relacion con el puesto del personal
            $table->unsignedBigInteger('puesto_id')->nullable();
            $table->foreign('puesto_id')->references('id')->on('puestos');
            // Relacion con el departamento del personal
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personales');
    }
};
