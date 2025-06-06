<?php

namespace Tests\Feature\TipoMascota;

use App\Models\User;
use App\Models\TipoMascota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use PHPUnit\Framework\Attributes\Test;

class TipoMascotaCrudTest extends TestCase
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
    public function un_empleado_puede_ver_la_lista_de_tipos_de_mascotas()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $response = $this->get(route('empleado.tipoMascota.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function un_empleado_puede_registrar_un_nuevo_tipo_de_mascota()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $response = $this->post(route('empleado.tipoMascota.store'), [
            'nombre' => 'Reptil',
        ]);

        $response->assertRedirect(route('empleado.tipoMascota.index'));
        $this->assertDatabaseHas('tipo_mascotas', ['nombre' => 'Reptil']);
    }

}

