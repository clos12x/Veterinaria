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
       Schema::create('direcciones_envio', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->string('direccion');
    $table->string('zona')->nullable();
    $table->string('ciudad')->default('Santa Cruz');
    $table->string('referencia')->nullable();
    $table->string('telefono')->nullable();
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones_envio');
    }
};
