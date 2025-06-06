<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ajuste;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjusteController extends Controller
{
    public function create()
    {
        $productos = DB::table('productos')->get();
        $almacenes = DB::table('almacenes')->get();
        return view('empleado.ajuste.create', compact('productos', 'almacenes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id',
            'id_almacen' => 'required|exists:almacenes,id',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'glosa' => 'required|string',
            'fecha' => 'required|date',
        ]);

        Ajuste::create([
            'id_producto' => $request->id_producto,
            'id_almacen' => $request->id_almacen,
            'tipo' => $request->tipo,
            'cantidad' => $request->cantidad,
            'glosa' => $request->glosa,
            'fecha' => $request->fecha,
            'id_usuario' => auth::id(),
        ]);

        $stock = DB::table('almacen_producto')
            ->where('id_producto', $request->id_producto)
            ->where('id_almacen', $request->id_almacen);

        if ($request->tipo == 'entrada') {
            $stock->increment('stock', $request->cantidad);
        } else {
            $actual = $stock->value('stock');
            if ($request->cantidad > $actual) {
                return back()->with('error', 'No hay stock suficiente.');
            }
            $stock->decrement('stock', $request->cantidad);
        }

        Movimiento::create([
            'id_producto' => $request->id_producto,
            'id_almacen' => $request->id_almacen,
            'id_usuario' => auth::id(),
            'tipo' => $request->tipo,
            'cantidad' => $request->cantidad,
            'detalle' => 'Ajuste manual: ' . $request->glosa,
        ]);

        return redirect()->back()->with('success', 'Ajuste registrado correctamente.');
    }
   public function index(Request $request)
{
    $orden = $request->get('orden', 'ajustes.id'); // default: id
    $direccion = $request->get('direccion', 'desc'); // default: descendente

    $ajustes = DB::table('ajustes')
        ->join('productos', 'productos.id', '=', 'ajustes.id_producto')
        ->join('almacenes', 'almacenes.id', '=', 'ajustes.id_almacen')
        ->leftJoin('almacen_producto', function ($join) {
            $join->on('ajustes.id_producto', '=', 'almacen_producto.id_producto')
                 ->on('ajustes.id_almacen', '=', 'almacen_producto.id_almacen');
        })
        ->select(
            'ajustes.*',
            'productos.nombre as producto',
            'almacenes.nombre as almacen',
            'almacen_producto.stock as stock_actual'
        )
        ->orderBy($orden, $direccion)
        ->get();

    return view('empleado.ajuste.index', compact('ajustes', 'orden', 'direccion'));
    }

}