<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Almacen;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $proveedores = Proveedor::all();
        $almacenes = Almacen::all();

        $query = Compra::with(['proveedor', 'almacen']);

        if ($request->filled('proveedor')) {
            $query->where('id_proveedor', $request->proveedor);
        }

        if ($request->filled('almacen')) {
            $query->where('id_almacen', $request->almacen);
        }

        $compras = $query->orderBy('id', 'asc')->get();

        return view('empleado.compra.index', compact('compras', 'proveedores', 'almacenes'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::with('almacenes')->get();
        $almacenes = Almacen::all();
        return view('empleado.compra.create', compact('proveedores', 'productos', 'almacenes'));
    }

    public function store(Request $request)
    {
        $productosFiltrados = collect($request->productos)->filter(function ($item) {
            return isset($item['cantidad']) && $item['cantidad'] > 0;
        })->values()->all();

        $request->merge(['productos' => $productosFiltrados]);

        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id',
            'id_almacen' => 'required|exists:almacenes,id',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($request->productos as $item) {
                $total += $item['cantidad'] * $item['precio_unitario'];
            }

            $compra = Compra::create([
                'id_proveedor' => $request->id_proveedor,
                'id_almacen' => $request->id_almacen,
                'fecha' => now(),
                'total' => $total,
            ]);

            foreach ($request->productos as $item) {
                DetalleCompra::create([
                    'id_compra' => $compra->id,
                    'id_producto' => $item['id_producto'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                ]);

                $registro = DB::table('almacen_producto')
                    ->where('id_almacen', $request->id_almacen)
                    ->where('id_producto', $item['id_producto'])
                    ->first();

                if ($registro) {
                    DB::table('almacen_producto')
                        ->where('id', $registro->id)
                        ->update([
                            'stock' => $registro->stock + $item['cantidad'],
                            'updated_at' => now(),
                        ]);
                } else {
                    DB::table('almacen_producto')->insert([
                        'id_almacen' => $request->id_almacen,
                        'id_producto' => $item['id_producto'],
                        'stock' => $item['cantidad'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                Movimiento::create([
                    'id_producto' => $item['id_producto'],
                    'id_almacen' => $request->id_almacen,
                    'id_usuario' => Auth::id(),
                    'tipo' => 'entrada',
                    'cantidad' => $item['cantidad'],
                    'detalle' => 'Compra al proveedor',
                ]);
            }

            DB::commit();
            return redirect()->route('empleado.compras.index')->with('success', 'Compra registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar la compra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $compra = Compra::with(['proveedor', 'almacen', 'detalles.producto'])->findOrFail($id);
        return view('empleado.compra.show', compact('compra'));
    }
}