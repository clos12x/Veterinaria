<?php

namespace Tests\Unit\Venta;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;

class DetalleVentaModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function la_tabla_detalle_ventas_tiene_las_columnas_esperadas(): void
    {
        $this->assertTrue(Schema::hasColumns('detalle_ventas', [
            'id', 'id_venta', 'id_producto', 'cantidad', 'precio_unitario', 'created_at', 'updated_at'
        ]));
    }
}

