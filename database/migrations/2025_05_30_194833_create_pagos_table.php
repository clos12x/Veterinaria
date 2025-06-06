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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->enum('metodo', ['tarjeta', 'transferencia']);
            $table->string('referencia'); // ahora es obligatorio

            // Datos de tarjeta (si aplica)
            $table->string('nombre_titular')->nullable();
            $table->string('numero_tarjeta')->nullable();
            $table->string('expiracion')->nullable();
            $table->string('cvv')->nullable();

            // Nuevo: comprobante para transferencia/QR
            $table->string('comprobante')->nullable();

            $table->timestamps();

            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
