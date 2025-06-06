<?php

namespace Tests\Unit\Movimiento;

use Tests\TestCase;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Almacen;
use App\Models\Movimiento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;

class MovimientoModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function la_tabla_movimientos_tiene_las_columnas_esperadas(): void
    {
        $this->assertTrue(Schema::hasColumns('movimientos', [
            'id', 'id_producto', 'id_almacen', 'id_usuario',
            'tipo', 'cantidad', 'detalle', 'created_at', 'updated_at'
        ]));
    }

    #[Test]
    public function puede_crear_un_movimiento_valido(): void
    {
        $usuario = User::create([
            'name' => 'Empleado Movimiento',
            'email' => 'mov@dev.com',
            'password' => bcrypt('12345678')
        ]);

        $categoria = Categoria::create([
            'nombre' => 'Medicamentos'
        ]);

        $producto = Producto::create([
            'nombre' => 'Vacuna triple',
            'descripcion' => 'Dosis única',
            'precio' => 45.00,
            'stock' => 100,
            'id_categoria' => $categoria->id_categoria
        ]);

        $almacen = Almacen::create([
            'nombre' => 'Central',
            'ubicacion' => 'Calle 1'
        ]);

        $movimiento = Movimiento::create([
            'id_producto' => $producto->id,
            'id_almacen' => $almacen->id,
            'id_usuario' => $usuario->id,
            'tipo' => 'entrada',
            'cantidad' => 10,
            'detalle' => 'Ingreso por compra'
        ]);

        $this->assertDatabaseHas('movimientos', [
            'id' => $movimiento->id,
            'tipo' => 'entrada',
            'cantidad' => 10,
            'detalle' => 'Ingreso por compra'
        ]);
    }
}

