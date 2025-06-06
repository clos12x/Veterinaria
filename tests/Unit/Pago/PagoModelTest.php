<?php

namespace Tests\Unit\Pago;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use App\Models\User;
use App\Models\Venta;
use App\Models\Pago;

class PagoModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function la_tabla_pagos_tiene_las_columnas_esperadas(): void
    {
        $this->assertTrue(Schema::hasColumns('pagos', [
            'id', 'venta_id', 'metodo', 'referencia',
            'nombre_titular', 'numero_tarjeta', 'expiracion', 'cvv', 'comprobante',
            'created_at', 'updated_at'
        ]));
    }

    #[Test]
    public function puede_crear_un_pago_con_tarjeta(): void
    {
        $cliente = User::create([
            'name' => 'Cliente Test',
            'email' => 'cliente@dev.com',
            'password' => bcrypt('password')
        ]);

        $venta = Venta::create([
            'id_cliente' => $cliente->id,
            'total' => 150.00,
            'fecha' => now(),
        ]);

        $pago = Pago::create([
            'venta_id' => $venta->id,
            'metodo' => 'tarjeta',
            'referencia' => 'TAR-123456',
            'nombre_titular' => 'Juan Pérez',
            'numero_tarjeta' => '4111111111111111',
            'expiracion' => '12/28',
            'cvv' => '123',
            'comprobante' => null,
        ]);

        $this->assertDatabaseHas('pagos', [
            'id' => $pago->id,
            'metodo' => 'tarjeta',
            'referencia' => 'TAR-123456',
        ]);
    }

    #[Test]
    public function puede_crear_un_pago_por_transferencia(): void
    {
        $cliente = User::create([
            'name' => 'Cliente Transferencia',
            'email' => 'trans@dev.com',
            'password' => bcrypt('password')
        ]);

        $venta = Venta::create([
            'id_cliente' => $cliente->id,
            'total' => 200.00,
            'fecha' => now(),
        ]);

        $pago = Pago::create([
            'venta_id' => $venta->id,
            'metodo' => 'transferencia',
            'referencia' => 'TRF-654321',
            'nombre_titular' => null,
            'numero_tarjeta' => null,
            'expiracion' => null,
            'cvv' => null,
            'comprobante' => 'comprobante_qr_001.jpg',
        ]);

        $this->assertDatabaseHas('pagos', [
            'id' => $pago->id,
            'metodo' => 'transferencia',
            'referencia' => 'TRF-654321',
            'comprobante' => 'comprobante_qr_001.jpg',
        ]);
    }
}
