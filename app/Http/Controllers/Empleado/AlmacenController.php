<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Almacen;

class AlmacenController extends Controller
{
    public function index(Request $request)
    {
        $query = Almacen::query();

        // Aplicar búsqueda si viene desde el formulario
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $almacenes = $query->get();

        return view('empleado.almacen.index', compact('almacenes'));
    }

    public function create()
    {
        $almacenes = Almacen::all();
        return view('empleado.almacen.create', compact('almacenes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        Almacen::create($request->all());

        return redirect()->route('empleado.almacen.index')->with('success', 'Almacén creado exitosamente.');
    }

    public function edit($id)
    {
        $almacen = Almacen::findOrFail($id);
        return view('empleado.almacen.edit', compact('almacen'));
    }

    public function update(Request $request, $id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->update($request->only(['nombre', 'ubicacion']));

        return redirect()->route('empleado.almacen.index')
            ->with('success', 'Almacén actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->delete();

        return back()->with('success', 'Almacén eliminado exitosamente.');
    }
}
