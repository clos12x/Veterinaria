<?php

namespace Tests\Unit\Compra;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;

class CompraModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_una_compra_con_datos_validos()
    {
        $proveedorId = DB::table('proveedores')->insertGetId([
            'nombre' => 'Proveedor Uno',
            'telefono' => '78945612',
            'email' => 'proveedor@x.com',
            'direccion' => 'Av. Principal',
        ]);

        DB::table('compras')->insert([
            'id_proveedor' => $proveedorId,
            'fecha' => Carbon::now()->format('Y-m-d'),
            'total' => 200.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('compras', [
            'id_proveedor' => $proveedorId,
            'total' => 200.00,
        ]);
    }
}

