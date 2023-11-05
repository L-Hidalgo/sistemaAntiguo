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
            $table->string('propuestos')->nullable()->default('');
            $table->string('estado')->nullable()->default('');
            $table->string('remitente')->nullable()->default('');
            $table->timestamp('fechaAccion')->nullable();
            $table->string('responsable')->nullable()->default('');
            $table->string('informeCuadro')->nullable()->default('');
            $table->timestamp('fechaInformeCuadro')->nullable();
            $table->string('hpHr')->nullable()->default('');
            $table->string('sippase')->nullable()->default('');
            $table->string('idioma')->nullable()->default('');
            $table->timestamp('fechaMovimiento')->nullable();
            $table->string('nombreMovimiento')->nullable()->default('');
            $table->string('itemOrigen')->nullable()->default('');
            $table->string('cargoOrigen')->nullable()->default('');
            $table->string('memorandum')->nullable()->default('');
            $table->string('RA')->nullable()->default('');
            $table->timestamp('fechaMemorialRap')->nullable();
            $table->string('sayri')->nullable()->default('');
            $table->unsignedBigInteger('personal_id');
            //$table->unsignedBigInteger('puesto_id');
            $table->foreign('personal_id')->references('id')->on('personales');
           // $table->foreign('puesto_id')->references('id')->on('puestos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('procesoDeIncorporaciones');
    }
};
