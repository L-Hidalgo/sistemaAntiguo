<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('requisitosPuesto', function (Blueprint $table) {
            $table->id();
            $table->string('objetivoPuesto')->nullable();
            $table->string('formacion')->nullable();
            $table->string('experienciaProfesionalSegunCargo')->nullable();
            $table->string('experienciaRelacionadAlAreaFormacion')->nullable();
            $table->string('experienciaEnFuncionesDeMando')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisitosPuesto');
    }
};
