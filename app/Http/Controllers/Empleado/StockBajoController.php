<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Producto;

class StockBajoController extends Controller
{
    public function index()
    {
        // 🔥 Sumamos stock por producto en todos los almacenes
        $productosConStock = DB::table('almacen_producto')
            ->select('id_producto', DB::raw('SUM(stock) as stock_total'))
            ->groupBy('id_producto')
            ->having('stock_total', '<', 5) // 🚨 Menos de 5 unidades
            ->get();

        $productos = Producto::whereIn('id', $productosConStock->pluck('id_producto'))->get();

        return view('empleado.stockbajo.index', compact('productos', 'productosConStock'));
    }
}
