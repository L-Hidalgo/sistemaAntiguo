<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('requisitosPuestos', function (Blueprint $table) {
            $table->id();
            $table->string('objetivoPuesto')->nullable();
            $table->string('formacion')->nullable();
            $table->string('experienciaProfesionalSegunCargo')->nullable();
            $table->string('experienciaRelacionadAlAreaFormacion')->nullable();
            $table->string('experienciaEnFuncionesDeMando')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requisitosPuestos');
    }
};
