<?php

namespace Tests\Feature\Categoria;

use Tests\TestCase;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class CategoriaCrudTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function un_empleado_puede_crear_una_categoria()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('empleado.categorias.store'), [
            'nombre' => 'Accesorios',
        ]);

        $response->assertRedirect(route('empleado.categorias.index'));
        $this->assertDatabaseHas('categorias', ['nombre' => 'Accesorios']);
    }

    #[Test]
    public function un_empleado_puede_editar_una_categoria()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();
        $categoria = Categoria::create(['nombre' => 'Comida']);

        $response = $this->actingAs($user)->put(route('empleado.categorias.update', $categoria->id_categoria), [
            'nombre' => 'Alimentos',
        ]);

        $response->assertRedirect(route('empleado.categorias.index'));
        $this->assertDatabaseHas('categorias', ['nombre' => 'Alimentos']);
    }

    #[Test]
    public function un_empleado_puede_eliminar_una_categoria()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();
        $categoria = Categoria::create(['nombre' => 'Juguetes']);

        $response = $this->actingAs($user)->delete(route('empleado.categorias.destroy', $categoria->id_categoria));
        $response->assertRedirect();
        $this->assertDatabaseMissing('categorias', ['id_categoria' => $categoria->id_categoria]);
    }

    #[Test]
    public function un_empleado_puede_ver_el_listado_de_categorias()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->get(route('empleado.categorias.index'));

        $response->assertStatus(200);
        $response->assertViewIs('empleado.categoria.index');
    }
}
