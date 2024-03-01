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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('idventa');
            $table->unsignedBigInteger('idcliente');
            $table->unsignedBigInteger('idtrabajador');
            $table->date('fecha');
            $table->string('tipo_comprobante');
            $table->string('serie');
            $table->string('correlativo');
            $table->decimal('igv', 10, 2);
            $table->string('estado');
            $table->timestamps();

            $table->foreign('idcliente')->references('idcliente')->on('clientes')->onDelete('cascade');
            $table->foreign('idtrabajador')->references('idtrabajador')->on('trabajadores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
