<?php

namespace Tests\Unit\Categoria;

use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CategoriaModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_categoria()
    {
        $categoria = Categoria::create(['nombre' => 'Accesorios']);
        $this->assertDatabaseHas('categorias', ['nombre' => 'Accesorios']);
    }

    #[Test]
    public function puede_actualizar_categoria()
    {
        $categoria = Categoria::create(['nombre' => 'Comida']);
        $categoria->update(['nombre' => 'Alimentos']);
        $this->assertDatabaseHas('categorias', ['nombre' => 'Alimentos']);
    }

    #[Test]
    public function puede_eliminar_categoria()
    {
        $categoria = Categoria::create(['nombre' => 'Juguetes']);
        $categoria->delete();
        $this->assertDatabaseMissing('categorias', ['id_categoria' => $categoria->id_categoria]);
    }

    #[Test]
    public function puede_listar_categorias()
    {
        Categoria::create(['nombre' => 'Vacunas']);
        Categoria::create(['nombre' => 'Alimentos']);

        $categorias = Categoria::all();

        $this->assertCount(2, $categorias);
        $this->assertEquals('Vacunas', $categorias[0]->nombre);
    }
}
