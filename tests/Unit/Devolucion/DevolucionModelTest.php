<?php

namespace Tests\Unit\Devolucion;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\User;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Categoria;
use App\Models\Devolucion;

class DevolucionModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function la_tabla_devoluciones_tiene_las_columnas_esperadas(): void
    {
        $this->assertTrue(Schema::hasColumns('devoluciones', [
            'id', 'id_venta', 'id_producto', 'cantidad', 'motivo', 'id_usuario', 'created_at', 'updated_at'
        ]));
    }

    #[Test]
    public function puede_crear_una_devolucion_con_datos_validos(): void
    {
        $usuario = User::create([
            'name' => 'Empleado Test',
            'email' => 'empleado@dev.com',
            'password' => bcrypt('password')
        ]);

        $categoria = Categoria::create([
            'nombre' => 'Medicamentos'
        ]);

        $producto = Producto::create([
            'nombre' => 'Desparasitante',
            'descripcion' => 'Para perros medianos',
            'precio' => 30.00,
            'stock' => 100,
            'id_categoria' => $categoria->id_categoria, // ⚠️ CORRECTO
        ]);

        $venta = Venta::create([
            'id_cliente' => $usuario->id,
            'total' => 30.00,
            'fecha' => now(),
        ]);

        $devolucion = Devolucion::create([
            'id_venta' => $venta->id,
            'id_producto' => $producto->id,
            'cantidad' => 1,
            'motivo' => 'Producto defectuoso',
            'id_usuario' => $usuario->id,
        ]);

        $this->assertDatabaseHas('devoluciones', [
            'id' => $devolucion->id,
            'cantidad' => 1,
            'motivo' => 'Producto defectuoso',
        ]);
    }
}

