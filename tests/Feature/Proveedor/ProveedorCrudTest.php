<?php

namespace Tests\Feature\Proveedor;

use App\Models\User;
use App\Models\Proveedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use PHPUnit\Framework\Attributes\Test;

class ProveedorCrudTest extends TestCase
{
    use RefreshDatabase;

    private function crearEmpleado()
    {
        return User::factory()->create([
            'name' => 'Empleado Test',
            'email' => 'empleado@demo.com',
            'password' => Hash::make('password'),
        ]);
    }

    #[Test]
    public function un_empleado_puede_ver_la_lista_de_proveedores()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $response = $this->get(route('empleado.proveedores.index'));
        $response->assertStatus(200);
    }

    #[Test]
    public function un_empleado_puede_registrar_un_proveedor()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $response = $this->post(route('empleado.proveedores.store'), [
            'nombre' => 'Proveedor Uno',
            'telefono' => '71234567',
            'email' => 'uno@correo.com',
            'direccion' => 'Av. Banzer',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('proveedores', [
            'nombre' => 'Proveedor Uno',
            'telefono' => '71234567',
            'email' => 'uno@correo.com',
            'direccion' => 'Av. Banzer',
        ]);
    }

    #[Test]
    public function un_empleado_puede_actualizar_un_proveedor()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $proveedor = Proveedor::create([
            'nombre' => 'Antiguo',
            'telefono' => '71111111',
            'email' => 'a@ejemplo.com',
            'direccion' => 'Calle A',
        ]);

        $response = $this->put(route('empleado.proveedores.update', ['proveedor' => $proveedor]), [
            'nombre' => 'Nuevo Nombre',
            'telefono' => '79999999',
            'email' => 'nuevo@ejemplo.com',
            'direccion' => 'Calle Actualizada',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('proveedores', ['nombre' => 'Nuevo Nombre']);
    }

    #[Test]
    public function un_empleado_puede_eliminar_un_proveedor()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $proveedor = Proveedor::create([
            'nombre' => 'A eliminar',
            'telefono' => '70000000',
            'email' => 'eliminar@ejemplo.com',
            'direccion' => 'Calle Final',
        ]);

        $response = $this->delete(route('empleado.proveedores.destroy', ['proveedor' => $proveedor]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('proveedores', ['id' => $proveedor->id]);
    }
}

