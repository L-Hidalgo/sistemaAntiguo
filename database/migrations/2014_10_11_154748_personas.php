<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('ci')->unique();
            $table->string('an')->nullable();
            $table->string('exp')->nullable();
            $table->string('nombres');
            $table->string('primerApellido');
            $table->string('segundoApellido')->nullable();
            $table->string('nombreCompleto');
            $table->string('sexo');
            $table->date('fechaNacimiento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personas');
    }
};
