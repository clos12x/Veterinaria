<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Proveedor;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
class ReporteCompraController extends Controller
{
    public function index(Request $request)
    {
        $proveedores = Proveedor::all();

        $compras = Compra::with('proveedor')
            ->when($request->filled('fecha_inicio') && $request->filled('fecha_fin'), function ($query) use ($request) {
                $query->whereBetween('fecha', [
                    Carbon::parse($request->fecha_inicio)->startOfDay(),
                    Carbon::parse($request->fecha_fin)->endOfDay()
                ]);
            })
            ->when($request->filled('id_proveedor'), function ($query) use ($request) {
                $query->where('id_proveedor', $request->id_proveedor);
            })
            ->latest()
            ->get();

        $total = $compras->sum('total');

        return view('admin.compras.reporte', compact('compras', 'proveedores', 'total'));
    }
    public function descargarPdf(Request $request)
{
    $compras = Compra::with('proveedor')
        ->when($request->filled('fecha_inicio') && $request->filled('fecha_fin'), function ($query) use ($request) {
            $query->whereBetween('fecha', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        })
        ->when($request->filled('id_proveedor'), function ($query) use ($request) {
            $query->where('id_proveedor', $request->id_proveedor);
        })
        ->latest()
        ->get();

    $total = $compras->sum('total');

    $pdf = Pdf::loadView('admin.compras.reporte_pdf', compact('compras', 'total'))->setPaper('a4', 'portrait');

    return $pdf->download('reporte_compras_' . now()->format('Y_m_d') . '.pdf');
}
}