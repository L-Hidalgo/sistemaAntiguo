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
            $table->string('nombre')->nullable();
            $table->decimal('salario')->nullable();
            $table->string('salarioLiteral')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('puestos');
    }
};
