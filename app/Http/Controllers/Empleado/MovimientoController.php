<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Almacen;
use App\Models\Producto;

class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = Movimiento::with('producto', 'almacen', 'usuario');

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('id_almacen')) {
            $query->where('id_almacen', $request->id_almacen);
        }

        if ($request->filled('id_producto')) {
            $query->where('id_producto', $request->id_producto);
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $movimientos = $query->orderByDesc('created_at')->get();
        $almacenes = Almacen::all();
        $productos = Producto::all();

        return view('empleado.movimientos.index', compact('movimientos', 'almacenes', 'productos'));
    }
}