<?php

namespace Tests\Feature\Cliente;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use PHPUnit\Framework\Attributes\Test;

class ClienteRealCrudTest extends TestCase
{
    use RefreshDatabase;

    private function crearEmpleado()
    {
        return User::factory()->create([
            'name' => 'Empleado',
            'email' => 'empleado@demo.com',
            'password' => Hash::make('password'),
            'role' => 'empleado',
        ]);
    }

    #[Test]
    public function un_empleado_puede_ver_la_lista_de_clientes()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $response = $this->get(route('empleado.verClientes'));
        $response->assertStatus(200);
    }

    #[Test]
    public function un_empleado_puede_registrar_un_cliente()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $response = $this->post(route('empleado.registrarCliente'), [
            'name' => 'Luis Gómez',
            'email' => 'luis@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('empleado.formularioCliente'));

        $this->assertDatabaseHas('users', [
            'name' => 'Luis Gómez',
            'email' => 'luis@example.com',
            'role' => 'cliente',
        ]);
    }

    #[Test]
    public function un_empleado_puede_actualizar_un_cliente()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $cliente = User::create([
            'name' => 'Carlos',
            'email' => 'carlos@correo.com',
            'password' => Hash::make('123456'),
            'role' => 'cliente',
        ]);

        $response = $this->post(route('empleado.actualizarCliente', $cliente->id), [
            'name' => 'Carlos Actualizado',
            'email' => 'carlosnuevo@correo.com',
        ]);

        $response->assertRedirect(route('empleado.verClientes'));

        $this->assertDatabaseHas('users', [
            'id' => $cliente->id,
            'name' => 'Carlos Actualizado',
            'email' => 'carlosnuevo@correo.com',
        ]);
    }

    #[Test]
    public function un_empleado_puede_eliminar_un_cliente()
    {
        $empleado = $this->crearEmpleado();
        $this->actingAs($empleado);

        $cliente = User::create([
            'name' => 'Ana',
            'email' => 'ana@example.com',
            'password' => Hash::make('123456'),
            'role' => 'cliente',
        ]);

        $response = $this->delete(route('empleado.eliminarCliente', $cliente->id));

        $response->assertRedirect(route('empleado.verClientes'));

        $this->assertDatabaseMissing('users', ['id' => $cliente->id]);
    }
}
