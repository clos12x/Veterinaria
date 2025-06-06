<?php

namespace Tests\Unit\Direccion;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use App\Models\User;
use App\Models\DireccionEnvio;

class DireccionEnvioModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function la_tabla_direcciones_envio_tiene_las_columnas_esperadas(): void
    {
        $this->assertTrue(Schema::hasColumns('direcciones_envio', [
            'id', 'user_id', 'direccion', 'zona', 'ciudad', 'referencia', 'telefono', 'created_at', 'updated_at'
        ]));
    }

    #[Test]
    public function puede_crear_una_direccion_de_envio_valida(): void
    {
        $usuario = User::create([
            'name' => 'Cliente Dirección',
            'email' => 'direccion@dev.com',
            'password' => bcrypt('12345678')
        ]);

        $direccion = DireccionEnvio::create([
            'user_id' => $usuario->id,
            'direccion' => 'Av. Beni #123',
            'zona' => 'Norte',
            'ciudad' => 'Santa Cruz',
            'referencia' => 'Frente al parque',
            'telefono' => '70012345',
        ]);

        $this->assertDatabaseHas('direcciones_envio', [
            'id' => $direccion->id,
            'direccion' => 'Av. Beni #123',
            'ciudad' => 'Santa Cruz',
        ]);
    }
}
