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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id('id_consulta');
            $table->text('descripcion');
            $table->date('fecha');
            $table->decimal('precio_consulta', 8, 2)->default(20.00); // precio fijo
    
            $table->unsignedBigInteger('id_mascota');
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_veterinario');
    
            $table->timestamps();
    
            $table->foreign('id_mascota')->references('id')->on('mascotas')->onDelete('cascade');
            $table->foreign('id_empleado')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_veterinario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
