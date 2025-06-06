<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TipoMascota;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    public function index()
    {
        return view('dashboards.empleado');
    }

    public function formularioCliente()
    {
        return view('empleado.registrar-cliente');
    }

    public function registrarCliente(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // ✅ Crear y guardar cliente en variable
        $cliente = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cliente',
        ]);

        // ✅ Asignar TODOS los permisos automáticamente (si aplica)
        $todosLosPermisos = Permission::pluck('id');
        $cliente->permissions()->sync($todosLosPermisos);

        return redirect()->route('empleado.formularioCliente')->with('success', 'Cliente registrado con éxito.');
    }

    // Método para ver todos los clientes con búsqueda
    public function verClientes(Request $request)
    {
        $busqueda = $request->input('busqueda');

        $clientes = User::where('role', 'cliente')
            ->when($busqueda, function ($query, $busqueda) {
                return $query->where(function ($q) use ($busqueda) {
                    $q->where('name', 'like', "%$busqueda%")
                      ->orWhere('email', 'like', "%$busqueda%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('empleado.ver-clientes', compact('clientes'));
    }

    // Editar cliente
    public function editarCliente($id)
    {
        $cliente = User::where('role', 'cliente')->findOrFail($id);
        return view('empleado.editar-cliente', compact('cliente'));
    }

    // Actualizar cliente
    public function actualizarCliente(Request $request, $id)
    {
        $cliente = User::where('role', 'cliente')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $cliente->id,
        ]);

        $cliente->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('empleado.verClientes')->with('success', 'Cliente actualizado con éxito.');
    }

    // Eliminar cliente
    public function eliminarCliente($id)
    {
        $cliente = User::where('role', 'cliente')->findOrFail($id);
        $cliente->delete();

        return redirect()->route('empleado.verClientes')->with('success', 'Cliente eliminado.');
    }
}
