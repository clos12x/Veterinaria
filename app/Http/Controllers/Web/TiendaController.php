<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
class TiendaController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::all();
    $productos = Producto::with(['categoria', 'almacenes']);

    if ($request->has('categoria')) {
        $productos->where('id_categoria', $request->categoria);
    }

    $productos = $productos->get();

    return view('tienda.index', compact('categorias', 'productos'));
    }
}
