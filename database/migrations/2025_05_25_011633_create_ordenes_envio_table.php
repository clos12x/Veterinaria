<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordenes_envio', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_venta');
        $table->enum('tipo_entrega', ['delivery', 'retiro']);
        $table->unsignedBigInteger('direccion_envio_id')->nullable();
        $table->string('estado')->default('pendiente');
        $table->timestamps();

        $table->foreign('id_venta')->references('id')->on('ventas')->onDelete('cascade');
        $table->foreign('direccion_envio_id')->references('id')->on('direcciones_envio')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_envio');
    }
};
