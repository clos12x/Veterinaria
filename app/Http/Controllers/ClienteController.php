<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; // añade esta línea para poder usar el modelo Producto

class ClienteController extends Controller
{
    public function index()
    {
        $productos = Producto::all(); // o cualquier lógica que necesites para los productos
        return view('dashboards.cliente', compact('productos'));
    }
}
