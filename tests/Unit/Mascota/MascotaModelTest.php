<?php

namespace Tests\Unit\Mascota;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mascota;
use App\Models\TipoMascota;
use PHPUnit\Framework\Attributes\Test;

class MascotaModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_registrar_una_mascota()
    {
        $cliente = User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@demo.com',
            'password' => Hash::make('123456'),
            'role' => 'cliente',
        ]);

        $tipo = TipoMascota::create([
            'id_tipoMascota' => 99,
            'nombre' => 'Canino',
        ]);

        $mascota = Mascota::create([
            'nombre' => 'Firulais',
            'edad' => '3',
            'raza' => 'Pitbull',
            'sexo' => 'Macho',
            'peso' => 18.5,
            'id_cliente' => $cliente->id,
            'id_tipoMascota' => $tipo->id_tipoMascota,
        ]);

        $this->assertDatabaseHas('mascotas', [
            'nombre' => 'Firulais',
            'raza' => 'Pitbull',
            'id_cliente' => $cliente->id,
        ]);
    }

    #[Test]
    public function puede_listar_mascotas()
    {
        $cliente = User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@demo.com',
            'password' => Hash::make('123456'),
            'role' => 'cliente',
        ]);

        $tipo = TipoMascota::create([
            'nombre' => 'Felino',
        ]);

        Mascota::create([
            'nombre' => 'Michi',
            'edad' => '2',
            'raza' => 'Persa',
            'sexo' => 'Hembra',
            'peso' => 4.3,
            'id_cliente' => $cliente->id,
            'id_tipoMascota' => $tipo->id_tipoMascota,
        ]);

        $mascotas = Mascota::all();

        $this->assertCount(1, $mascotas);
        $this->assertEquals('Michi', $mascotas->first()->nombre);
    }
}
