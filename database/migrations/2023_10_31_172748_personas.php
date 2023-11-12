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
            $table->string('ci')->nullable();
            $table->string('an')->nullable();
            $table->string('exp')->nullable();
            $table->string('nombres')->nullable();
            $table->string('primerApellido')->nullable();
            $table->string('segundoApellido')->nullable();
            $table->string('nombreCompleto')->nullable();
            $table->string('sexo')->nullable();
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
