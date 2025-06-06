<?php

namespace Tests\Unit\Orden;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use App\Models\User;
use App\Models\Venta;
use App\Models\OrdenEnvio;

class OrdenEnvioModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function la_tabla_ordenes_envio_tiene_las_columnas_esperadas(): void
    {
        $this->assertTrue(Schema::hasColumns('ordenes_envio', [
            'id', 'id_venta', 'tipo_entrega', 'direccion_envio_id', 'estado', 'created_at', 'updated_at'
        ]));
    }

    #[Test]
    public function puede_crear_una_orden_de_envio_valida(): void
    {
        $cliente = User::create([
            'name' => 'Cliente Prueba',
            'email' => 'cliente@dev.com',
            'password' => bcrypt('password')
        ]);

        $venta = Venta::create([
            'id_cliente' => $cliente->id,
            'total' => 80.00,
            'fecha' => now(),
        ]);

        $orden = OrdenEnvio::create([
            'id_venta' => $venta->id,
            'tipo_entrega' => 'delivery',
            'direccion_envio_id' => null, // porque puede ser nullable
            'estado' => 'pendiente',
        ]);

        $this->assertDatabaseHas('ordenes_envio', [
            'id' => $orden->id,
            'tipo_entrega' => 'delivery',
            'estado' => 'pendiente',
        ]);
    }
}

