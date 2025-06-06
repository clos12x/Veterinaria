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
    Schema::table('consultas', function (Blueprint $table) {
        $table->boolean('cobrado')->default(false);
        $table->unsignedBigInteger('id_empleado_cobro')->nullable();
        $table->timestamp('fecha_cobro')->nullable();

        $table->foreign('id_empleado_cobro')->references('id')->on('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            //
        });
    }
};
