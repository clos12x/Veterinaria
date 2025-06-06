<?php

namespace App\Http\Controllers\Empleado;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Producto;
use App\Models\Movimiento; // ✅ IMPORTANTE
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function create()
    {
        $almacenes = Almacen::all();
        $productos = Producto::all();
        return view('empleado.stock.create', compact('almacenes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_almacen' => 'required|exists:almacenes,id',
            'id_producto' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $stockActual = DB::table('almacen_producto')
            ->where('id_almacen', $request->id_almacen)
            ->where('id_producto', $request->id_producto)
            ->first();

        if ($stockActual) {
            // Si ya existe, actualizamos sumando
            DB::table('almacen_producto')
                ->where('id', $stockActual->id)
                ->update([
                    'stock' => $stockActual->stock + $request->cantidad
                ]);
        } else {
            // Si no existe, lo creamos
            DB::table('almacen_producto')->insert([
                'id_almacen' => $request->id_almacen,
                'id_producto' => $request->id_producto,
                'stock' => $request->cantidad,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ✅ REGISTRAMOS MOVIMIENTO DE ENTRADA
        Movimiento::create([
            'id_producto' => $request->id_producto,
            'id_almacen' => $request->id_almacen,
            'id_usuario' => Auth::id(),
            'tipo' => 'entrada',
            'cantidad' => $request->cantidad,
            'detalle' => 'Ingreso de stock manual'
        ]);

        return back()->with('success', 'Stock actualizado correctamente.');
    }
    public function verStock()
{
    $almacenes = \App\Models\Almacen::all();

    $stockPorAlmacen = [];

    foreach ($almacenes as $almacen) {
        $productos = DB::table('almacen_producto')
            ->join('productos', 'almacen_producto.id_producto', '=', 'productos.id')
            ->where('almacen_producto.id_almacen', $almacen->id)
            ->select('productos.nombre', 'almacen_producto.stock')
            ->get();

        $stockPorAlmacen[] = [
            'almacen' => $almacen,
            'productos' => $productos
        ];
    }

    return view('empleado.stock.ver-stock', compact('stockPorAlmacen'));
}
public function formularioTransferir()
{
    $almacenes = \App\Models\Almacen::all();
    $productos = \App\Models\Producto::all();

    return view('empleado.stock.transferir', compact('almacenes', 'productos'));
}

// Lógica para realizar transferencia
public function realizarTransferencia(Request $request)
{
    $request->validate([
        'id_producto' => 'required|exists:productos,id',
        'id_almacen_origen' => 'required|exists:almacenes,id',
        'id_almacen_destino' => 'required|exists:almacenes,id|different:id_almacen_origen',
        'cantidad' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        // Restar stock del almacén origen
        $origen = DB::table('almacen_producto')
            ->where('id_producto', $request->id_producto)
            ->where('id_almacen', $request->id_almacen_origen)
            ->lockForUpdate()
            ->first();

        if (!$origen || $origen->stock < $request->cantidad) {
            return back()->with('error', 'Stock insuficiente en el almacén de origen.');
        }

        DB::table('almacen_producto')
            ->where('id', $origen->id)
            ->update([
                'stock' => $origen->stock - $request->cantidad,
                'updated_at' => now(),
            ]);

        // Sumar stock al almacén destino
        $destino = DB::table('almacen_producto')
            ->where('id_producto', $request->id_producto)
            ->where('id_almacen', $request->id_almacen_destino)
            ->first();

        if ($destino) {
            DB::table('almacen_producto')
                ->where('id', $destino->id)
                ->update([
                    'stock' => $destino->stock + $request->cantidad,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('almacen_producto')->insert([
                'id_almacen' => $request->id_almacen_destino,
                'id_producto' => $request->id_producto,
                'stock' => $request->cantidad,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Registrar el movimiento (opcional para historial)
        \App\Models\Movimiento::create([
            'id_producto' => $request->id_producto,
            'id_almacen' => $request->id_almacen_origen,
            'id_usuario' => Auth::id(),
            'tipo' => 'salida',
            'cantidad' => $request->cantidad,
            'detalle' => 'Transferencia a otro almacén',
        ]);

        \App\Models\Movimiento::create([
            'id_producto' => $request->id_producto,
            'id_almacen' => $request->id_almacen_destino,
            'id_usuario' => Auth::id(),
            'tipo' => 'entrada',
            'cantidad' => $request->cantidad,
            'detalle' => 'Recepción de transferencia',
        ]);

        DB::commit();

        return redirect()->route('empleado.almacenes.stock')->with('success', 'Transferencia realizada correctamente.');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Error en la transferencia: ' . $e->getMessage());
    }
}
}