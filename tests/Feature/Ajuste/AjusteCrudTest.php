<?php

namespace Tests\Feature\Ajuste;

use App\Models\User;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AjusteCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    #[Test]
    public function un_empleado_puede_crear_un_ajuste()
    {
        $empleado = User::factory()->create();
        $this->actingAs($empleado);

        $categoria = Categoria::create(['nombre' => 'Medicamento']);

        $producto = \App\Models\Producto::create([
            'nombre' => 'Desparasitante',
            'descripcion' => 'Producto veterinario',
            'precio' => 12,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $almacenId = \DB::table('almacenes')->insertGetId([
            'nombre' => 'Central',
            'ubicacion' => 'Av. 1ro de Mayo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('almacen_producto')->insert([
            'id_producto' => $producto->id,
            'id_almacen' => $almacenId,
            'stock' => 30,
        ]);

        $response = $this->post(route('empleado.ajustes.store'), [
            'id_producto' => $producto->id,
            'id_almacen' => $almacenId,
            'tipo' => 'entrada',
            'cantidad' => 10,
            'glosa' => 'Ingreso inicial',
            'fecha' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('ajustes', [
            'id_producto' => $producto->id,
            'id_almacen' => $almacenId,
            'tipo' => 'entrada',
            'cantidad' => 10,
        ]);
    }

    #[Test]
    public function un_empleado_puede_ver_la_lista_de_ajustes()
    {
        $empleado = User::factory()->create();
        $this->actingAs($empleado);

        $categoria = Categoria::create(['nombre' => 'Accesorios']);

        $producto = \App\Models\Producto::create([
            'nombre' => 'Collar',
            'descripcion' => 'Para perro',
            'precio' => 20,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $almacenId = \DB::table('almacenes')->insertGetId([
            'nombre' => 'Secundario',
            'ubicacion' => 'Av. Secundaria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('almacen_producto')->insert([
            'id_producto' => $producto->id,
            'id_almacen' => $almacenId,
            'stock' => 100,
        ]);

        \DB::table('ajustes')->insert([
            'id_producto' => $producto->id,
            'id_almacen' => $almacenId,
            'tipo' => 'entrada',
            'cantidad' => 5,
            'glosa' => 'Prueba de ajuste',
            'fecha' => now()->format('Y-m-d'),
            'id_usuario' => $empleado->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get(route('empleado.ajustes.index'));
        $response->assertStatus(200);
        $response->assertSee('Prueba de ajuste');
    }
}