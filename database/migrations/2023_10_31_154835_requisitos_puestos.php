<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('requisitos_puestos', function (Blueprint $table) {
            $table->unsignedBigInteger('puesto_id');
            $table->unsignedBigInteger('requisito_id');
            $table->timestamps();
       
            $table->foreign('puesto_id')->references('id')->on('puestos')->onDelete('cascade');
            $table->foreign('requisito_id')->references('id')->on('requisitos')->onDelete('cascade');

            // clave primaria compuesta
            $table->primary(['puesto_id', 'requisito_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('requisitos_puestos');
    }
};