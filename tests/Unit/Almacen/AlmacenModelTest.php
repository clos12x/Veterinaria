<?php

namespace Tests\Unit\Almacen;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;

class AlmacenModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_almacen()
    {
        DB::table('almacenes')->insert([
            'nombre' => 'Sucursal Norte',
            'ubicacion' => 'Av. Principal #123',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('almacenes', [
            'nombre' => 'Sucursal Norte',
            'ubicacion' => 'Av. Principal #123',
        ]);
    }

    #[Test]
    public function puede_listar_almacenes()
    {
        DB::table('almacenes')->insert([
            'nombre' => 'Depósito Central',
            'ubicacion' => 'Calle 5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $almacenes = DB::table('almacenes')->where('nombre', 'Depósito Central')->get();
        $this->assertCount(1, $almacenes);
        $this->assertEquals('Calle 5', $almacenes[0]->ubicacion);
    }

    #[Test]
    public function puede_actualizar_almacen()
    {
        $id = DB::table('almacenes')->insertGetId([
            'nombre' => 'Sucursal Sur',
            'ubicacion' => 'Antigua ubicación',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('almacenes')->where('id', $id)->update([
            'nombre' => 'Sucursal Actualizada',
            'ubicacion' => 'Nueva ubicación',
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('almacenes', [
            'id' => $id,
            'nombre' => 'Sucursal Actualizada',
            'ubicacion' => 'Nueva ubicación',
        ]);
    }

    #[Test]
    public function puede_eliminar_almacen()
    {
        $id = DB::table('almacenes')->insertGetId([
            'nombre' => 'Sucursal Temporal',
            'ubicacion' => 'Eliminarme',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('almacenes')->where('id', $id)->delete();

        $this->assertDatabaseMissing('almacenes', ['id' => $id]);
    }
}
