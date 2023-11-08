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
            $table->integer('item')->nullable();
            $table->string('denominacion')->nullable();
            $table->decimal('salario')->nullable();
            $table->string('salarioLiteral')->nullable();
            $table->text('objetivo')->nullable();
            $table->string('estado')->nullable();
            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('puestos');
    }
};
