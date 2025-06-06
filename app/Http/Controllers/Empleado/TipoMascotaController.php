<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoMascota;

class TipoMascotaController extends Controller
{
    public function index(Request $request)
    {
        $query = TipoMascota::query();

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $tipos = $query->orderBy('nombre')->paginate(10);

        return view('empleado.tipo-mascota.index', compact('tipos'));
    }

    public function create()
    {
        return view('empleado.tipo-mascota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_mascotas,nombre',
        ]);

        TipoMascota::create(['nombre' => $request->nombre]);

        return redirect()->route('empleado.tipoMascota.index')->with('success', 'Tipo registrado correctamente.');
    }

    public function destroy($id)
    {
        TipoMascota::findOrFail($id)->delete();
        return back()->with('success', 'Tipo eliminado.');
    }
}
