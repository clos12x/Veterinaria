<?php

namespace Tests\Feature\Servicio;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\TipoMascota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class ServicioCrudTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function un_veterinario_puede_agregar_servicio_a_una_consulta()
    {
        $empleado = User::factory()->create(['role' => 'empleado']);
        $veterinario = User::factory()->create(['role' => 'veterinario']);
        $cliente = User::factory()->create(['role' => 'cliente']);

        $tipo = TipoMascota::create(['nombre' => 'Canino']);

        $mascota = Mascota::create([
            'nombre' => 'Luna',
            'edad' => '3',
            'raza' => 'Caniche',
            'id_cliente' => $cliente->id,
            'id_tipoMascota' => $tipo->id_tipoMascota,
        ]);

        $consulta = Consulta::create([
            'descripcion' => 'Chequeo general',
            'fecha' => Carbon::now()->format('Y-m-d'),
            'id_mascota' => $mascota->id,
            'id_empleado' => $empleado->id,
            'id_veterinario' => $veterinario->id,
            'precio_consulta' => 20.00,
        ]);

        $this->actingAs($veterinario);

        // ⚠️ ESTA ES LA CLAVE: PASAR 'id' COMO ARRAY
        $response = $this->post(route('veterinario.consulta.servicio.store', ['id' => $consulta->getKey()]), [
            'nombre' => 'Vacuna antirrábica',
            'precio' => 50.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('servicios', [
            'nombre' => 'Vacuna antirrábica',
            'precio' => 50.00,
            'id_consulta' => $consulta->getKey(),
        ]);
    }
}
