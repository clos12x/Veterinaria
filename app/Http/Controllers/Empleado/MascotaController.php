<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\TipoMascota;
use App\Models\User;

class MascotaController extends Controller
{
    public function index()
    {
        $mascotas = Mascota::with(['tipo', 'cliente'])->get();
        return view('empleado.mascota.index', compact('mascotas'));
    }

    public function create()
    {
        $clientes = User::where('role', 'cliente')->get();
        $tipos = TipoMascota::all();

        return view('empleado.mascota.create', compact('clientes', 'tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'required|string|max:50',
            'raza' => 'required|string|max:255',
            'id_cliente' => 'required|exists:users,id',
            'id_tipoMascota' => 'required|exists:tipo_mascotas,id_tipoMascota',
        ]);

        Mascota::create($request->all());

        return redirect()->route('empleado.mascota.index')->with('success', 'Mascota registrada correctamente.');
    }
    public function buscarMascotas(Request $request)
{
    $busqueda = $request->input('busqueda');

    $mascotas = \App\Models\Mascota::with(['tipo', 'cliente'])
        ->when($busqueda, function ($query, $busqueda) {
            $query->where('nombre', 'like', "%$busqueda%")
                  ->orWhere('raza', 'like', "%$busqueda%")
                  ->orWhereHas('tipo', function ($q) use ($busqueda) {
                      $q->where('nombre', 'like', "%$busqueda%");
                  })
                  ->orWhereHas('cliente', function ($q) use ($busqueda) {
                      $q->where('name', 'like', "%$busqueda%");
                  });
        })
        ->get();

    return view('empleado.mascota.index', compact('mascotas'));
}
}