<?php

namespace Tests\Unit\Producto;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProductoModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_producto()
    {
        $categoria = Categoria::create(['nombre' => 'Vitaminas']);

        $producto = Producto::create([
            'nombre' => 'Antipulgas',
            'descripcion' => 'Protege contra pulgas',
            'imagen' => 'antipulgas.jpg',
            'precio' => 25.50,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $this->assertDatabaseHas('productos', ['nombre' => 'Antipulgas']);
    }

    #[Test]
    public function puede_editar_producto()
    {
        $categoria = Categoria::create(['nombre' => 'Accesorios']);

        $producto = Producto::create([
            'nombre' => 'Shampoo',
            'descripcion' => 'Para perros',
            'imagen' => 'shampoo.jpg',
            'precio' => 10,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $producto->update([
            'nombre' => 'Shampoo Premium',
            'descripcion' => 'Mejorado para piel sensible',
            'precio' => 15
        ]);

        $this->assertDatabaseHas('productos', ['nombre' => 'Shampoo Premium']);
    }

    #[Test]
    public function puede_eliminar_producto()
    {
        $categoria = Categoria::create(['nombre' => 'Juguetes']);

        $producto = Producto::create([
            'nombre' => 'Pelota',
            'descripcion' => 'Juguete para perro',
            'imagen' => 'pelota.jpg',
            'precio' => 5,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $producto->delete();

        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }

    #[Test]
    public function puede_listar_productos()
    {
        $categoria = Categoria::create(['nombre' => 'Alimentos']);

        Producto::create([
            'nombre' => 'Croquetas',
            'descripcion' => 'Para cachorros',
            'imagen' => 'croquetas.jpg',
            'precio' => 18,
            'id_categoria' => $categoria->id_categoria,
        ]);

        Producto::create([
            'nombre' => 'Carne enlatada',
            'descripcion' => 'Alta en proteínas',
            'imagen' => 'carne.jpg',
            'precio' => 22,
            'id_categoria' => $categoria->id_categoria,
        ]);

        $productos = Producto::all();
        $this->assertCount(2, $productos);
    }
}
