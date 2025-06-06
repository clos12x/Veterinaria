<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Venta;

class HistorialController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('detalles.producto')
            ->where('id_cliente', Auth::id())
            ->orderByDesc('fecha')
            ->get();

        return view('cliente.historial.index', compact('ventas'));
    }
}