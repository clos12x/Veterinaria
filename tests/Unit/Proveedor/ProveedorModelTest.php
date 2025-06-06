<?php

namespace Tests\Unit\Proveedor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Proveedor;
use PHPUnit\Framework\Attributes\Test;

class ProveedorModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_listar_proveedores()
    {
        Proveedor::create([
            'nombre' => 'Proveedor 1',
            'telefono' => '71234567',
            'email' => 'prov1@correo.com',
            'direccion' => 'Calle 1',
        ]);

        Proveedor::create([
            'nombre' => 'Proveedor 2',
            'telefono' => '72345678',
            'email' => 'prov2@correo.com',
            'direccion' => 'Calle 2',
        ]);

        $proveedores = Proveedor::all();

        $this->assertCount(2, $proveedores);
        $this->assertEquals('Proveedor 1', $proveedores[0]->nombre);
    }

    #[Test]
    public function puede_registrar_un_proveedor()
    {
        $proveedor = Proveedor::create([
            'nombre' => 'Proveedor Uno',
            'telefono' => '71234567',
            'email' => 'uno@correo.com',
            'direccion' => 'Av. Banzer',
        ]);

        $this->assertDatabaseHas('proveedores', [
            'nombre' => 'Proveedor Uno',
            'telefono' => '71234567',
            'email' => 'uno@correo.com',
            'direccion' => 'Av. Banzer',
        ]);
    }

    #[Test]
    public function puede_actualizar_un_proveedor()
    {
        $proveedor = Proveedor::create([
            'nombre' => 'Antiguo',
            'telefono' => '71111111',
            'email' => 'a@ejemplo.com',
            'direccion' => 'Calle A',
        ]);

        $proveedor->update([
            'nombre' => 'Nuevo Nombre',
            'telefono' => '79999999',
            'email' => 'nuevo@ejemplo.com',
            'direccion' => 'Calle Actualizada',
        ]);

        $this->assertDatabaseHas('proveedores', [
            'nombre' => 'Nuevo Nombre',
            'telefono' => '79999999',
            'email' => 'nuevo@ejemplo.com',
            'direccion' => 'Calle Actualizada',
        ]);
    }

    #[Test]
    public function puede_eliminar_un_proveedor()
    {
        $proveedor = Proveedor::create([
            'nombre' => 'A eliminar',
            'telefono' => '70000000',
            'email' => 'eliminar@ejemplo.com',
            'direccion' => 'Calle Final',
        ]);

        $proveedor->delete();

        $this->assertDatabaseMissing('proveedores', ['id' => $proveedor->id]);
    }
}
