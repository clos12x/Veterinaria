<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        // Verificamos si hay un término de búsqueda
        $buscar = $request->input('buscar');

        if ($buscar) {
            // Filtrar las categorías por nombre si se proporciona término de búsqueda
            $categorias = Categoria::where('nombre', 'like', '%' . $buscar . '%')->get();
        } else {
            // Caso contrario, traer todas
            $categorias = Categoria::all();
        }

        return view('empleado.categoria.index', compact('categorias', 'buscar'));
    }

    public function create()
    {
        return view('empleado.categoria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        Categoria::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('empleado.categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('empleado.categoria.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('empleado.categorias.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return back()->with('success', 'Categoría eliminada.');
    }
}
