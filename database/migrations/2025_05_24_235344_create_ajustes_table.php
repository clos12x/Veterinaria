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
    Schema::create('ajustes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_producto');
        $table->unsignedBigInteger('id_almacen');
        $table->enum('tipo', ['entrada', 'salida']);
        $table->integer('cantidad');
        $table->string('glosa');
        $table->date('fecha');
        $table->unsignedBigInteger('id_usuario');
        $table->timestamps();

        $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');
        $table->foreign('id_almacen')->references('id')->on('almacenes')->onDelete('cascade');
        $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustes');
    }
};
