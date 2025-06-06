<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;
use Illuminate\Support\Facades\Auth;
class CobroConsultaController extends Controller
{
    public function index()
    {
        // Solo consultas NO cobradas
        $consultas = Consulta::with('mascota', 'veterinario')
            ->where('cobrado', false)
            ->get();

        return view('empleado.cobro.index', compact('consultas'));
    }

    public function cobrar($id)
{
    $consulta = \App\Models\Consulta::findOrFail($id);

    $consulta->update([
        'cobrado' => true,
        'id_empleado_cobro' => auth::id(),
        'fecha_cobro' => now(),
    ]);

    // Redirige automáticamente al recibo
    return redirect()->route('empleado.cobros.recibo', $consulta->id_consulta);
}

public function recibo($id)
{
    $consulta = \App\Models\Consulta::with(['mascota.cliente', 'veterinario', 'empleadoCobro', 'servicios'])->findOrFail($id);

    return view('empleado.cobro.recibo', compact('consulta'));
}
}