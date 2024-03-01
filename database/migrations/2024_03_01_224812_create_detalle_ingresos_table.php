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

        Schema::create('detalle_ingresos', function (Blueprint $table) {
            $table->id('iddetalle_ingreso');
            $table->unsignedBigInteger('idingreso');
            $table->unsignedBigInteger('idarticulo');
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->integer('stock_inicial');
            $table->integer('stock_actual');
            $table->date('fecha_produccion');
            $table->date('fecha_vencimiento')->nullable();

            $table->foreign('idingreso')->references('idingreso')->on('ingresos')->onDelete('cascade');
            $table->foreign('idarticulo')->references('idarticulo')->on('articulos')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ingresos');
    }
};
