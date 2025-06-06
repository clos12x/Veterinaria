<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_almacen')->nullable(); // almacén (opcional)
            $table->unsignedBigInteger('id_usuario'); // quien hizo el movimiento
            $table->enum('tipo', ['entrada', 'salida']);
            $table->integer('cantidad');
            $table->text('detalle')->nullable();
            $table->timestamps();

            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('id_almacen')->references('id')->on('almacenes')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
