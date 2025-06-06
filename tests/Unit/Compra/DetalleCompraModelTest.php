<?php

namespace Tests\Unit\Compra;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;

class DetalleCompraModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function la_tabla_detalle_compras_tiene_las_columnas_esperadas(): void
    {
        $this->assertTrue(Schema::hasColumns('detalle_compras', [
            'id', 'id_compra', 'id_producto', 'cantidad', 'precio_unitario', 'created_at', 'updated_at'
        ]));
    }
}


