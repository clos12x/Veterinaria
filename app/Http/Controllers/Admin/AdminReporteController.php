<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminReporteController extends Controller
{
    public function index(Request $request)
{
    $hoy = Carbon::today();
    $inicioSemana = Carbon::now()->startOfWeek();
    $inicioMes = Carbon::now()->startOfMonth();
    $inicioAño = Carbon::now()->startOfYear();

    // Filtros
    $fechaInicio = $request->fecha_inicio ? Carbon::parse($request->fecha_inicio)->startOfDay() : null;
    $fechaFin = $request->fecha_fin ? Carbon::parse($request->fecha_fin)->endOfDay() : null;
    $tipo = $request->tipo;

    // 🟦 Parte 1: Resumen general (no cambia)
    $consultasDia = Consulta::whereDate('fecha', $hoy)->sum('precio_consulta');
    $consultasSemana = Consulta::whereBetween('fecha', [$inicioSemana, now()])->sum('precio_consulta');
    $consultasMes = Consulta::whereBetween('fecha', [$inicioMes, now()])->sum('precio_consulta');
    $consultasAño = Consulta::whereBetween('fecha', [$inicioAño, now()])->sum('precio_consulta');

    $ventasDia = Venta::whereDate('fecha', $hoy)->sum('total');
    $ventasSemana = Venta::whereBetween('fecha', [$inicioSemana, now()])->sum('total');
    $ventasMes = Venta::whereBetween('fecha', [$inicioMes, now()])->sum('total');
    $ventasAño = Venta::whereBetween('fecha', [$inicioAño, now()])->sum('total');

    $serviciosDia = Servicio::whereHas('consulta', fn($q) => $q->whereDate('fecha', $hoy))->sum('precio');
    $serviciosSemana = Servicio::whereHas('consulta', fn($q) => $q->whereBetween('fecha', [$inicioSemana, now()]))->sum('precio');
    $serviciosMes = Servicio::whereHas('consulta', fn($q) => $q->whereBetween('fecha', [$inicioMes, now()]))->sum('precio');
    $serviciosAño = Servicio::whereHas('consulta', fn($q) => $q->whereBetween('fecha', [$inicioAño, now()]))->sum('precio');

    // 🟧 Parte 2: Si aplican filtros
    $consultasTotal = 0;
    $ventasTotal = 0;
    $serviciosTotal = 0;
    $totalGeneral = 0;

    if ($fechaInicio && $fechaFin) {
        // 🔥 Si el usuario pone fechas, SIEMPRE filtrar todo (consultas + servicios + ventas)
        
        $consultasTotal = Consulta::whereBetween('fecha', [$fechaInicio, $fechaFin])->sum('precio_consulta');
    
        $serviciosTotal = Servicio::whereHas('consulta', function($q) use ($fechaInicio, $fechaFin) {
            $q->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        })->sum('precio');
    
        $ventasTotal = Venta::whereBetween('fecha', [$fechaInicio, $fechaFin])->sum('total');
    
        $totalGeneral = $consultasTotal + $ventasTotal + $serviciosTotal;
    }

    // Top productos y veterinarios
    $topProductos = DetalleVenta::select('id_producto', DB::raw('SUM(cantidad) as total_vendidos'))
        ->groupBy('id_producto')
        ->orderByDesc('total_vendidos')
        ->with('producto')
        ->take(5)
        ->get();

    $topVeterinarios = Consulta::select('id_veterinario', DB::raw('COUNT(*) as total_consultas'))
        ->groupBy('id_veterinario')
        ->orderByDesc('total_consultas')
        ->with('veterinario')
        ->take(5)
        ->get();

    $ventasMensuales = Venta::selectRaw('MONTH(fecha) as mes, SUM(total) as total')
        ->whereYear('fecha', now()->year)
        ->groupBy('mes')
        ->pluck('total', 'mes');

    $consultasMensuales = Consulta::selectRaw('MONTH(fecha) as mes, SUM(precio_consulta) as total')
        ->whereYear('fecha', now()->year)
        ->groupBy('mes')
        ->pluck('total', 'mes');

    return view('admin.reportes.index', compact(
        'consultasDia', 'consultasSemana', 'consultasMes', 'consultasAño',
        'ventasDia', 'ventasSemana', 'ventasMes', 'ventasAño',
        'serviciosDia', 'serviciosSemana', 'serviciosMes', 'serviciosAño',
        'consultasTotal', 'ventasTotal', 'serviciosTotal', 'totalGeneral',
        'ventasMensuales', 'consultasMensuales',
        'topProductos', 'topVeterinarios'
    ));
}
public function descargarPdf(Request $request)
{
    $hoy = Carbon::today();
    $inicioSemana = Carbon::now()->startOfWeek();
    $inicioMes = Carbon::now()->startOfMonth();
    $inicioAño = Carbon::now()->startOfYear();

    $fechaInicio = $request->fecha_inicio ? Carbon::parse($request->fecha_inicio)->startOfDay() : null;
    $fechaFin = $request->fecha_fin ? Carbon::parse($request->fecha_fin)->endOfDay() : null;

    // Datos generales
    $consultasDia = Consulta::whereDate('fecha', $hoy)->sum('precio_consulta');
    $consultasSemana = Consulta::whereBetween('fecha', [$inicioSemana, now()])->sum('precio_consulta');
    $consultasMes = Consulta::whereBetween('fecha', [$inicioMes, now()])->sum('precio_consulta');
    $consultasAño = Consulta::whereBetween('fecha', [$inicioAño, now()])->sum('precio_consulta');

    $ventasDia = Venta::whereDate('fecha', $hoy)->sum('total');
    $ventasSemana = Venta::whereBetween('fecha', [$inicioSemana, now()])->sum('total');
    $ventasMes = Venta::whereBetween('fecha', [$inicioMes, now()])->sum('total');
    $ventasAño = Venta::whereBetween('fecha', [$inicioAño, now()])->sum('total');

    $serviciosDia = Servicio::whereHas('consulta', fn($q) => $q->whereDate('fecha', $hoy))->sum('precio');
    $serviciosSemana = Servicio::whereHas('consulta', fn($q) => $q->whereBetween('fecha', [$inicioSemana, now()]))->sum('precio');
    $serviciosMes = Servicio::whereHas('consulta', fn($q) => $q->whereBetween('fecha', [$inicioMes, now()]))->sum('precio');
    $serviciosAño = Servicio::whereHas('consulta', fn($q) => $q->whereBetween('fecha', [$inicioAño, now()]))->sum('precio');

    // 🔥 Resumen filtrado
    $consultasTotal = 0;
    $ventasTotal = 0;
    $serviciosTotal = 0;
    $totalGeneral = 0;

    if ($fechaInicio && $fechaFin) {
        $consultasTotal = Consulta::whereBetween('fecha', [$fechaInicio, $fechaFin])->sum('precio_consulta');

        $serviciosTotal = Servicio::whereHas('consulta', function($q) use ($fechaInicio, $fechaFin) {
            $q->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        })->sum('precio');

        $ventasTotal = Venta::whereBetween('fecha', [$fechaInicio, $fechaFin])->sum('total');

        $totalGeneral = $consultasTotal + $ventasTotal + $serviciosTotal;
    }

    $topProductos = DetalleVenta::select('id_producto', DB::raw('SUM(cantidad) as total_vendidos'))
        ->groupBy('id_producto')
        ->orderByDesc('total_vendidos')
        ->with('producto')
        ->take(5)
        ->get();

    $topVeterinarios = Consulta::select('id_veterinario', DB::raw('COUNT(*) as total_consultas'))
        ->groupBy('id_veterinario')
        ->orderByDesc('total_consultas')
        ->with('veterinario')
        ->take(5)
        ->get();

    $pdf = Pdf::loadView('admin.reportes.pdf', compact(
        'consultasDia', 'consultasSemana', 'consultasMes', 'consultasAño',
        'ventasDia', 'ventasSemana', 'ventasMes', 'ventasAño',
        'serviciosDia', 'serviciosSemana', 'serviciosMes', 'serviciosAño',
        'consultasTotal', 'ventasTotal', 'serviciosTotal', 'totalGeneral',
        'topProductos', 'topVeterinarios'
    ));

    return $pdf->download('reporte_admin_' . now()->format('Y_m_d') . '.pdf');
}
}