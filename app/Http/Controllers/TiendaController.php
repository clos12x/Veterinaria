<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class TiendaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('productos')->get();
        return view('tienda.index', compact('categorias'));
    }
}