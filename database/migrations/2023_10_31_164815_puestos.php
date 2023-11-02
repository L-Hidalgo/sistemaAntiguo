<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('puestos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->decimal('salario')->nullable();
            $table->string('salarioLiteral')->nullable();
            // $table->unsignedBigInteger('personal_id');
            $table->unsignedBigInteger('requisitosPuesto_id');
            // $table->foreign('personal_id')->references('id')->on('personales');
            $table->foreign('requisitosPuesto_id')->references('id')->on('requisitosPuestos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('puestos');
    }
};
