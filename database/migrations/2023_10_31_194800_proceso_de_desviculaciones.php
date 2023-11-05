<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('procesoDeDesvinculaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable()->default('');
            $table->timestamp('renunciaRetiro')->nullable();
            $table->timestamp('ultimoDiaTrabajo')->nullable();
            $table->unsignedBigInteger('personal_id');
            //$table->unsignedBigInteger('puesto_id');
            $table->foreign('personal_id')->references('id')->on('personales');
            //$table->foreign('puesto_id')->references('id')->on('puestos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('procesoDeDesvinculaciones');
    }
};
