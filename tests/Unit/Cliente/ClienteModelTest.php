<?php

namespace Tests\Unit\Cliente;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class ClienteModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_listar_clientes()
    {
        User::create([
            'name' => 'Cliente 1',
            'email' => 'cliente1@example.com',
            'password' => Hash::make('123456'),
            'role' => 'cliente',
        ]);

        User::create([
            'name' => 'Cliente 2',
            'email' => 'cliente2@example.com',
            'password' => Hash::make('123456'),
            'role' => 'cliente',
        ]);

        $clientes = User::where('role', 'cliente')->get();

        $this->assertCount(2, $clientes);
        $this->assertEquals('cliente1@example.com', $clientes[0]->email);
    }

    #[Test]
    public function puede_registrar_cliente()
    {
        $cliente = User::create([
            'name' => 'Luis Gómez',
            'email' => 'luis@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'cliente',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Luis Gómez',
            'email' => 'luis@example.com',
            'role' => 'cliente',
        ]);
    }

    #[Test]
    public function puede_actualizar_cliente()
    {
        $cliente = User::create([
            'name' => 'Carlos',
            'email' => 'carlos@correo.com',
            'password' => Hash::make('123456'),
            'role' => 'cliente',
        ]);

        $cliente->update([
            'name' => 'Carlos Actualizado',
            'email' => 'carlosnuevo@correo.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $cliente->id,
            'name' => 'Carlos Actualizado',
            'email' => 'carlosnuevo@correo.com',
        ]);
    }

    #[Test]
    public function puede_eliminar_cliente()
    {
        $cliente = User::create([
            'name' => 'Ana',
            'email' => 'ana@example.com',
            'password' => Hash::make('123456'),
            'role' => 'cliente',
        ]);

        $cliente->delete();

        $this->assertDatabaseMissing('users', ['id' => $cliente->id]);
    }
}
