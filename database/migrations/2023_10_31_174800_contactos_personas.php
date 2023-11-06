<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('contactos_personas', function (Blueprint $table) {
            $table->id();
            $table->string('estado')->nullable()->default('');
            $table->unsignedBigInteger('persona_id');
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->unsignedBigInteger('contacto_id');
            $table->foreign('contacto_id')->references('id')->on('contactos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contactos_personas');
    }
};
