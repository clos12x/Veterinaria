<?php

namespace Tests\Unit\Venta;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;

class VentaModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_una_venta_valida()
    {
        // Crear cliente (user con rol cliente)
        $clienteId = DB::table('users')->insertGetId([
            'name' => 'Cliente de prueba',
            'email' => 'cliente@correo.com',
            'password' => bcrypt('password'),
            'role' => 'cliente',
        ]);

        // Insertar venta
        DB::table('ventas')->insert([
            'id_cliente' => $clienteId,
            'total' => 250.75,
            'fecha' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Verificar existencia
        $this->assertDatabaseHas('ventas', [
            'id_cliente' => $clienteId,
            'total' => 250.75,
        ]);
    }
}
