<?php

namespace Tests\Feature\Consulta;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mascota;
use App\Models\TipoMascota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class ConsultaCrudTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function un_empleado_puede_ver_el_formulario_para_crear_consulta()
    {
        $empleado = User::factory()->create(['role' => 'empleado']);
        $this->actingAs($empleado);

        $response = $this->get(route('empleado.consulta.create'));
        $response->assertStatus(200);
        $response->assertViewIs('empleado.consulta.create');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function un_empleado_puede_registrar_una_consulta()
    {
        $empleado = User::factory()->create(['role' => 'empleado']);
        $veterinario = User::factory()->create(['role' => 'veterinario']);
        $cliente = User::factory()->create(['role' => 'cliente']);

        $tipo = TipoMascota::create([
            'nombre' => 'Canino',
        ]);

        $mascota = Mascota::create([
            'nombre' => 'Toby',
            'edad' => '4',
            'raza' => 'Criollo',
            'id_cliente' => $cliente->id,
            'id_tipoMascota' => $tipo->id_tipoMascota, // <- usando la PK real
        ]);

        $this->actingAs($empleado);

        $response = $this->post(route('empleado.consulta.store'), [
            'descripcion' => 'Consulta general',
            'fecha' => Carbon::now()->format('Y-m-d'),
            'id_mascota' => $mascota->id,
            'id_veterinario' => $veterinario->id,
        ]);

        $response->assertRedirect(route('empleado.consulta.create'));
        $this->assertDatabaseHas('consultas', [
            'descripcion' => 'Consulta general',
            'id_mascota' => $mascota->id,
            'id_empleado' => $empleado->id,
            'id_veterinario' => $veterinario->id,
            'precio_consulta' => 20.00,
        ]);
    }
}



