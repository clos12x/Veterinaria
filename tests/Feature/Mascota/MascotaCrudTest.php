<?php

namespace Tests\Feature\Mascota;

use App\Models\User;
use App\Models\Mascota;
use App\Models\TipoMascota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use PHPUnit\Framework\Attributes\Test;

class MascotaCrudTest extends TestCase
{
    use RefreshDatabase;

    private function crearEmpleado()
    {
        return User::create([
            'name' => 'Empleado Test',
            'email' => 'empleado@demo.com',
            'password' => Hash::make('password'),
            'role' => 'empleado',
        ]);
    }

    #[Test]
    public function un_empleado_puede_ver_la_lista_de_mascotas()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $response = $this->get(route('empleado.mascota.index'));
        $response->assertStatus(200);
    }

    #[Test]
    public function un_empleado_puede_registrar_una_mascota()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        // Crear cliente manualmente
        $cliente = User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@demo.com',
            'password' => Hash::make('123456'),
            'role' => 'cliente',
        ]);

        // Crear tipo de mascota manualmente
        $tipo = TipoMascota::create([
            'id_tipoMascota' => 99,
            'nombre' => 'Canino',
        ]);

        $response = $this->post(route('empleado.mascota.store'), [
            'nombre' => 'Firulais',
            'edad' => '3',
            'raza' => 'Pitbull',
            'id_cliente' => $cliente->id,
            'id_tipoMascota' => $tipo->id_tipoMascota,
        ]);

        $response->assertRedirect(route('empleado.mascota.index'));
        $this->assertDatabaseHas('mascotas', ['nombre' => 'Firulais']);
    }
}
