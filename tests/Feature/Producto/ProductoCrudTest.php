<?php

namespace Tests\Feature\Producto;

use Tests\TestCase;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProductoCrudTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function un_empleado_puede_crear_un_producto()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();
        $categoria = Categoria::create(['nombre' => 'Vitaminas']);

        $response = $this->actingAs($user)->post(route('empleado.productos.store'), [
            'nombre' => 'Antipulgas',
            'descripcion' => 'Protege contra pulgas',
            'precio' => 25.50,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $response->assertRedirect(route('empleado.productos.index'));
        $this->assertDatabaseHas('productos', ['nombre' => 'Antipulgas']);
    }

    #[Test]
    public function un_empleado_puede_editar_un_producto()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();
        $categoria = Categoria::create(['nombre' => 'Accesorios']);
        $producto = Producto::create([
            'nombre' => 'Shampoo',
            'descripcion' => 'Para perros',
            'precio' => 10,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $response = $this->actingAs($user)->put(route('empleado.productos.update', $producto->id), [
            'nombre' => 'Shampoo Premium',
            'descripcion' => 'Mejorado para piel sensible',
            'precio' => 15,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $response->assertRedirect(route('empleado.productos.index'));
        $this->assertDatabaseHas('productos', ['nombre' => 'Shampoo Premium']);
    }

    #[Test]
    public function un_empleado_puede_eliminar_un_producto()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();
        $categoria = Categoria::create(['nombre' => 'Juguetes']);
        $producto = Producto::create([
            'nombre' => 'Pelota',
            'descripcion' => 'Juguete para perro',
            'precio' => 5,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $response = $this->actingAs($user)->delete(route('empleado.productos.destroy', $producto->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }

    #[Test]
    public function un_empleado_puede_ver_el_listado_de_productos()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->get(route('empleado.productos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('empleado.producto.index');
    }
}
