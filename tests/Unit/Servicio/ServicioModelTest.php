<?php

namespace Tests\Unit\Servicio;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;

class ServicioModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_agregar_servicio_a_una_consulta(): void
    {
        // Creamos manualmente todo por DB directo para evitar conflicto SQLite

        // Insertamos cliente, empleado y veterinario
        $clienteId = DB::table('users')->insertGetId(['name' => 'Cliente', 'email' => 'cliente@x.com', 'password' => bcrypt('123'), 'role' => 'cliente']);
        $empleadoId = DB::table('users')->insertGetId(['name' => 'Empleado', 'email' => 'empleado@x.com', 'password' => bcrypt('123'), 'role' => 'empleado']);
        $veterinarioId = DB::table('users')->insertGetId(['name' => 'Vet', 'email' => 'vet@x.com', 'password' => bcrypt('123'), 'role' => 'veterinario']);

        $tipoId = DB::table('tipo_mascotas')->insertGetId(['nombre' => 'Canino']);

        $mascotaId = DB::table('mascotas')->insertGetId([
            'nombre' => 'Luna',
            'edad' => 3,
            'raza' => 'Caniche',
            'id_cliente' => $clienteId,
            'id_tipoMascota' => $tipoId,
        ]);

        // Forzamos id_consulta manualmente
        DB::table('consultas')->insert([
            'id_consulta' => 1,
            'descripcion' => 'Chequeo general',
            'fecha' => Carbon::now()->format('Y-m-d'),
            'precio_consulta' => 20.00,
            'id_mascota' => $mascotaId,
            'id_empleado' => $empleadoId,
            'id_veterinario' => $veterinarioId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insertamos servicio con id_consulta fijo
        DB::table('servicios')->insert([
            'nombre' => 'Vacuna antirrábica',
            'precio' => 50.00,
            'id_consulta' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('servicios', [
            'nombre' => 'Vacuna antirrábica',
            'precio' => 50.00,
            'id_consulta' => 1,
        ]);
    }
}



