<?php

namespace Tests\Unit\TipoMascota;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\TipoMascota;
use PHPUnit\Framework\Attributes\Test;

class TipoMascotaModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_listar_tipos_de_mascotas()
    {
        TipoMascota::create(['nombre' => 'Canino']);
        TipoMascota::create(['nombre' => 'Felino']);

        $tipos = TipoMascota::all();

        $this->assertCount(2, $tipos);
        $this->assertEquals('Canino', $tipos[0]->nombre);
    }

    #[Test]
    public function puede_registrar_nuevo_tipo_de_mascota()
    {
        $tipo = TipoMascota::create(['nombre' => 'Reptil']);

        $this->assertDatabaseHas('tipo_mascotas', ['nombre' => 'Reptil']);
    }
}
