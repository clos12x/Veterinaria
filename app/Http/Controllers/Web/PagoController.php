<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pago;

class PagoController extends Controller
{
    public function mostrarFormulario($ventaId)
    {
        return view('tienda.forma_pago', compact('ventaId'));
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'metodo' => 'required|in:tarjeta,transferencia',
            'referencia' => 'nullable|string|max:100',
            'nombre_titular' => 'nullable|string|max:255',
            'numero_tarjeta' => 'nullable|string|max:20',
            'expiracion' => 'nullable|string|max:7',
            'cvv' => 'nullable|string|max:4',
        ]);

        // Guardar en base de datos
        Pago::create([
            'venta_id' => $request->venta_id,
            'metodo' => $request->metodo,
            'referencia' => $request->referencia,
            'nombre_titular' => $request->nombre_titular,
            'numero_tarjeta' => $request->numero_tarjeta,
            'expiracion' => $request->expiracion,
            'cvv' => $request->cvv,
        ]);

        // Redirigir a la vista del recibo correctamente
        return redirect()->route('web.carrito.recibo', $request->venta_id)
            ->with('success', '✅ Pago registrado correctamente.');
    }
}
