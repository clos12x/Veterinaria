<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devolucion;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DevolucionController extends Controller
{
    /**
     * Mostrar historial de devoluciones con filtros
     */
    public function index(Request $request)
    {
        $query = Devolucion::with(['producto', 'usuario', 'venta']);

        if ($request->filled('producto')) {
            $query->whereHas('producto', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->producto . '%');
            });
        }

        if ($request->filled('usuario')) {
            $query->where('id_usuario', $request->usuario);
        }

        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        $devoluciones = $query->latest()->get();
        $usuarios = User::where('role', 'empleado')->get();

        return view('empleado.devolucion.index', compact('devoluciones', 'usuarios'));
    }

    /**
     * Mostrar formulario de creación de devoluciones
     */
    public function create(Request $request)
    {
        $ventas = Venta::with('detalles.producto')->get();
        $ventaSeleccionada = $request->id_venta;

        return view('empleado.devolucion.create', compact('ventas', 'ventaSeleccionada'));
    }

    /**
     * Registrar múltiples devoluciones
     */
    public function storeMultiple(Request $request)
    {
        $request->validate([
            'id_venta' => 'required|exists:ventas,id',
            'productos' => 'required|array',
            'productos.*.id_producto' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'nullable|integer|min:0',
            'productos.*.motivo' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Generar un código único
            $codigoLote = 'DEV-' . str_pad(Devolucion::max('id') + 1, 4, '0', STR_PAD_LEFT);

            foreach ($request->productos as $producto) {
                $cantidad = intval($producto['cantidad'] ?? 0);
                if ($cantidad <= 0) continue;

                $detalleVenta = DB::table('detalle_ventas')
                    ->where('id_venta', $request->id_venta)
                    ->where('id_producto', $producto['id_producto'])
                    ->first();

                if (!$detalleVenta) continue;

                $cantidadDevuelta = Devolucion::where('id_venta', $request->id_venta)
                    ->where('id_producto', $producto['id_producto'])
                    ->sum('cantidad');

                $maxCantidad = $detalleVenta->cantidad - $cantidadDevuelta;

                if ($cantidad > $maxCantidad) continue;

                Devolucion::create([
                    'id_venta' => $request->id_venta,
                    'id_producto' => $producto['id_producto'],
                    'cantidad' => $cantidad,
                    'motivo' => $producto['motivo'] ?? null,
                    'id_usuario' => Auth::id(),
                    'codigo_lote' => $codigoLote,
                ]);

                DB::table('almacen_producto')
                    ->where('id_producto', $producto['id_producto'])
                    ->increment('stock', $cantidad);
            }

            DB::commit();
            return redirect()->route('empleado.devoluciones.index')->with('success', 'Devoluciones registradas correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
