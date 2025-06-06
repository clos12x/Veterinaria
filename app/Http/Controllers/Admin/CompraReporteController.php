<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Proveedor;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class CompraReporteController extends Controller
{
    public function index(Request $request)
    {
        $proveedores = Proveedor::all();
        $comprasQuery = Compra::with('proveedor');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $comprasQuery->whereBetween('fecha', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        }

        if ($request->filled('id_proveedor')) {
            $comprasQuery->where('id_proveedor', $request->id_proveedor);
        }

        $compras = $comprasQuery->get();
        $total = $compras->sum('total');

        return view('admin.compras.reporte', compact('compras', 'total', 'proveedores'));
    }

    public function pdf(Request $request)
    {
        $proveedores = Proveedor::all();
        $comprasQuery = Compra::with('proveedor');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $comprasQuery->whereBetween('fecha', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        }

        if ($request->filled('id_proveedor')) {
            $comprasQuery->where('id_proveedor', $request->id_proveedor);
        }

        $compras = $comprasQuery->get();
        $total = $compras->sum('total');

        $pdf = Pdf::loadView('admin.compras.reporte_pdf', compact('compras', 'total', 'proveedores'));
        return $pdf->stream('reporte_compras_' . now()->format('Y_m_d') . '.pdf');
    }
}
