<?php

namespace Tests\Feature\Almacen;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;

class AlmacenCrudTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function un_empleado_puede_crear_un_almacen()
    {
        $this->withoutMiddleware();
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('empleado.almacen.store'), [
            'nombre' => 'Sucursal Norte',
            'ubicacion' => 'Av. Principal #123',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('almacenes', [
            'nombre' => 'Sucursal Norte',
            'ubicacion' => 'Av. Principal #123',
        ]);
    }

    #[Test]
    public function un_empleado_puede_ver_la_lista_de_almacenes()
    {
        $this->withoutMiddleware();
        $this->actingAs(User::factory()->create());

        DB::table('almacenes')->insert([
            'nombre' => 'Depósito Central',
            'ubicacion' => 'Calle 5'
        ]);

        $response = $this->get(route('empleado.almacen.index'));
        $response->assertStatus(200);
        $response->assertSee('Depósito Central');
    }

    #[Test]
    public function un_empleado_puede_actualizar_un_almacen()
    {
        $this->withoutMiddleware();
        $this->actingAs(User::factory()->create());

        $id = DB::table('almacenes')->insertGetId([
            'nombre' => 'Sucursal Sur',
            'ubicacion' => 'Antigua ubicación'
        ]);

        $response = $this->put(route('empleado.almacen.update', $id), [
            'nombre' => 'Sucursal Actualizada',
            'ubicacion' => 'Nueva ubicación'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('almacenes', [
            'id' => $id,
            'nombre' => 'Sucursal Actualizada',
            'ubicacion' => 'Nueva ubicación'
        ]);
    }

    #[Test]
    public function un_empleado_puede_eliminar_un_almacen()
    {
        $this->withoutMiddleware();
        $this->actingAs(User::factory()->create());

        $id = DB::table('almacenes')->insertGetId([
            'nombre' => 'Sucursal Temporal',
            'ubicacion' => 'Eliminarme'
        ]);

        $response = $this->delete(route('empleado.almacen.destroy', $id));
        $response->assertRedirect();

        $this->assertDatabaseMissing('almacenes', ['id' => $id]);
    }
}
