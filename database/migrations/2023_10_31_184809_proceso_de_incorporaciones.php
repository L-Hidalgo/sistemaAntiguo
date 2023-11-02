<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('procesoDeIncorporaciones', function (Blueprint $table) {
            $table->id();
            $table->string('propuestos')->nullable();
            $table->string('estado')->nullable();
            $table->string('remitente')->nullable();
            $table->timestamp('fechaAccion')->nullable();
            $table->string('responsable')->nullable();
            $table->string('informeCuadro')->nullable();
            $table->timestamp('fechaInformeCuadro')->nullable();
            $table->string('hpHr')->nullable();
            $table->string('sippase')->nullable();
            $table->string('idioma');
            $table->timestamp('fechaMovimiento')->nullable();
            $table->string('nombreMovimiento')->nullable();
            $table->string('itemOrigen')->nullable();
            $table->string('cargoOrigen')->nullable();
            $table->string('memorandum')->unique();
            $table->string('RA')->nullable();
            $table->timestamp('fechaMemorialRap')->nullable();
            $table->string('sayri')->nullable();
            $table->unsignedBigInteger('personal_id');
            $table->unsignedBigInteger('puesto_id');
            $table->foreign('personal_id')->references('id')->on('personales');
            $table->foreign('puesto_id')->references('id')->on('puestos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('procesoDeIncorporaciones');
    }
};
