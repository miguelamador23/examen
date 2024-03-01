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

        Schema::create('articulos', function (Blueprint $table) {
            $table->id('idarticulo');
            $table->string('codigo');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->unsignedBigInteger('idcategoria');
            $table->unsignedBigInteger('idpresentacion');
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->integer('stock_inicial');
            $table->integer('stock_actual');
            $table->date('fecha_produccion');
            $table->date('fecha_vencimiento')->nullable();

            $table->foreign('idcategoria')->references('idcategoria')->on('categorias')->onDelete('cascade');
            $table->foreign('idpresentacion')->references('idpresentacion')->on('presentaciones')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
