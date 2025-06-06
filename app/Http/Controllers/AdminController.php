<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $bloqueados = LoginAttempt::where('blocked', true)->get();
        $numBloqueados = $bloqueados->count();

        $clientes = User::where('role', 'cliente')->count();
        $empleados = User::where('role', 'empleado')->count();
        $veterinarios = User::where('role', 'veterinario')->count();

        $productos = DB::table('detalle_ventas')
            ->join('productos', 'detalle_ventas.id_producto', '=', 'productos.id')
            ->select('productos.nombre', DB::raw('SUM(detalle_ventas.cantidad) as total'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $labelsProductos = json_encode($productos->pluck('nombre'));
        $valoresProductos = json_encode($productos->pluck('total'));

        $ganancias = DB::table('ventas')
            ->selectRaw("MONTH(fecha) as mes, SUM(total) as ganancia")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $labelsMeses = json_encode(array_map(fn($g) => $meses[$g->mes - 1], $ganancias->all()));
        $gananciasPorMes = json_encode($ganancias->pluck('ganancia'));

        if(request()->routeIs('admin.bloqueados')){
            return view('admin.bloqueados', compact('bloqueados', 'numBloqueados'))
                ->with('message', 'Tienes ' . $numBloqueados . ' correos bloqueados');
        }

        return view('dashboards.admin', compact(
            'numBloqueados',
            'clientes',
            'empleados',
            'veterinarios',
            'labelsProductos',
            'valoresProductos',
            'labelsMeses',
            'gananciasPorMes'
        ));
    }

    public function vistaReportes() {
        return view('admin.reportes.index');
    }

    public function formularioVeterinario() {
        return view('admin.registrar-veterinario');
    }

    public function registrarVeterinario(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'veterinario',
        ]);

        return redirect()->route('admin.veterinarios.index')->with('success', 'Veterinario registrado con éxito.');
    }

    public function formularioEmpleado() {
        return view('admin.registrar-empleado');
    }

    public function registrarEmpleado(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'empleado',
        ]);

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado registrado con éxito.');
    }

    public function verClientes(Request $request) {
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

        return view('admin.ver-clientes', compact('clientes'));
    }

    public function verPerfil() {
        $admin = auth()->user();
        return view('admin.perfil', compact('admin'));
    }

    public function editarCliente($id) {
        $cliente = User::where('role', 'cliente')->findOrFail($id);
        return view('admin.editar-cliente', compact('cliente'));
    }

    public function actualizarCliente(Request $request, $id) {
        $cliente = User::where('role', 'cliente')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $cliente->id,
        ]);

        $cliente->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.clientes')->with('success', 'Cliente actualizado correctamente.');
    }

    public function eliminarCliente($id) {
        $cliente = User::where('role', 'cliente')->findOrFail($id);
        $cliente->delete();

        return redirect()->route('admin.clientes')->with('success', 'Cliente eliminado correctamente.');
    }

    public function verVeterinarios(Request $request) {
        $busqueda = $request->input('busqueda');

        $veterinarios = User::where('role', 'veterinario')
            ->when($busqueda, function ($query, $busqueda) {
                return $query->where(function ($q) use ($busqueda) {
                    $q->where('name', 'like', "%$busqueda%")
                      ->orWhere('email', 'like', "%$busqueda%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.ver-veterinarios', compact('veterinarios'));
    }

    public function verEmpleados(Request $request) {
        $busqueda = $request->input('busqueda');

        $empleados = User::where('role', 'empleado')
            ->when($busqueda, function ($query, $busqueda) {
                return $query->where(function ($q) use ($busqueda) {
                    $q->where('name', 'like', "%$busqueda%")
                      ->orWhere('email', 'like', "%$busqueda%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.ver-empleados', compact('empleados'));
    }

    public function editarVeterinario($id) {
        $veterinario = User::where('role', 'veterinario')->findOrFail($id);
        return view('admin.editar-veterinario', compact('veterinario'));
    }

    public function actualizarVeterinario(Request $request, $id) {
        $veterinario = User::where('role', 'veterinario')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $veterinario->id,
        ]);

        $veterinario->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.veterinarios.index')->with('success', 'Veterinario actualizado correctamente.');
    }

    public function eliminarVeterinario($id) {
        $veterinario = User::where('role', 'veterinario')->findOrFail($id);
        $veterinario->delete();

        return redirect()->route('admin.veterinarios.index')->with('success', 'Veterinario eliminado correctamente.');
    }

    public function editarEmpleado($id) {
        $empleado = User::where('role', 'empleado')->findOrFail($id);
        return view('admin.editar-empleado', compact('empleado'));
    }

    public function actualizarEmpleado(Request $request, $id) {
        $empleado = User::where('role', 'empleado')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $empleado->id,
        ]);

        $empleado->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function eliminarEmpleado($id) {
        $empleado = User::where('role', 'empleado')->findOrFail($id);
        $empleado->delete();

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }

    public function desbloqueoUsuarios() {
        $bloqueados = LoginAttempt::where('blocked', true)->get();
        $numBloqueados = $bloqueados->count();

        return view('admin.bloqueados', compact('bloqueados', 'numBloqueados'))
            ->with('message', 'Tienes ' . $numBloqueados . ' correos bloqueados');
    }
}


