<?php

namespace Tests\Unit\Ajuste;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use PHPUnit\Framework\Attributes\Test;

class AjusteModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_un_ajuste()
    {
        $usuario = User::factory()->create();

        $categoria = Categoria::create(['nombre' => 'Medicamento']);

        $producto = Producto::create([
            'nombre' => 'Desparasitante',
            'descripcion' => 'Producto veterinario',
            'imagen' => 'desparasitante.jpg',
            'precio' => 12,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $almacenId = DB::table('almacenes')->insertGetId([
            'nombre' => 'Central',
            'ubicacion' => 'Av. 1ro de Mayo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('almacen_producto')->insert([
            'id_producto' => $producto->id,
            'id_almacen' => $almacenId,
            'stock' => 30,
        ]);

        DB::table('ajustes')->insert([
            'id_producto' => $producto->id,
            'id_almacen' => $almacenId,
            'tipo' => 'entrada',
            'cantidad' => 10,
            'glosa' => 'Ingreso inicial',
            'fecha' => now()->format('Y-m-d'),
            'id_usuario' => $usuario->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('ajustes', [
            'id_producto' => $producto->id,
            'id_almacen' => $almacenId,
            'cantidad' => 10,
            'glosa' => 'Ingreso inicial',
        ]);
    }

    #[Test]
    public function puede_listar_ajustes()
    {
        $usuario = User::factory()->create();

        $categoria = Categoria::create(['nombre' => 'Accesorios']);

        $producto = Producto::create([
            'nombre' => 'Collar',
            'descripcion' => 'Para perro',
            'imagen' => 'collar.jpg',
            'precio' => 20,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $almacenId = DB::table('almacenes')->insertGetId([
            'nombre' => 'Secundario',
            'ubicacion' => 'Av. Secundaria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('almacen_producto')->insert([
            'id_producto' => $producto->id,
            'id_almacen' => $almacenId,
            'stock' => 100,
        ]);

        DB::table('ajustes')->insert([
            'id_producto' => $producto->id,
            'id_almacen' => $almacenId,
            'tipo' => 'entrada',
            'cantidad' => 5,
            'glosa' => 'Prueba de ajuste',
            'fecha' => now()->format('Y-m-d'),
            'id_usuario' => $usuario->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ajustes = DB::table('ajustes')->where('glosa', 'like', '%ajuste%')->get();

        $this->assertCount(1, $ajustes);
        $this->assertEquals('Prueba de ajuste', $ajustes[0]->glosa);
    }
}

