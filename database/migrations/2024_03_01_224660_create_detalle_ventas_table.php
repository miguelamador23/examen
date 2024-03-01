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
    Schema::create('detalle_ventas', function (Blueprint $table) {
        $table->id('iddetalle_venta');
        $table->unsignedBigInteger('idventa');
        $table->unsignedBigInteger('iddetalle_ingreso');
        $table->integer('cantidad');
        $table->decimal('precio_venta', 10, 2);
        $table->decimal('descuento', 10, 2);

        $table->foreign('idventa')->references('idventa')->on('ventas')->onDelete('cascade');
        $table->foreign('iddetalle_ingreso')->references('idingreso')->on('detalle_ingresos')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas');
    }
};
