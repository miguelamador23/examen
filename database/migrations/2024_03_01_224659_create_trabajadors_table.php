<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id('idtrabajador');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('sexo'); 
            $table->date('fecha_nacimiento');
            $table->string('num_documento');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajadores');
    }
};
