<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        $permissions = \App\Models\Permission::orderBy('name')->get(); 
        $users = User::whereIn('role', ['empleado', 'veterinario'])->get();

        $selectedUser = null;
        $selectedPermissions = [];

        if ($request->has('user_id')) {
            $selectedUser = User::find($request->user_id);
            if ($selectedUser) {
                $selectedPermissions = $selectedUser->permissions->pluck('id')->toArray();
            }
        }

        return view('admin.permissions.index', compact('permissions', 'users', 'selectedUser', 'selectedPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions',
            'description' => 'nullable|string'
        ]);

        Permission::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return back()->with('success', 'Permiso creado correctamente');
    }

    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permissions' => 'nullable|array'
        ]);

        $user = User::findOrFail($request->user_id);

        DB::table('user_permission')->where('user_id', $user->id)->delete();

        if (!empty($request->permissions)) {
            foreach ($request->permissions as $permissionId) {
                DB::table('user_permission')->insert([
                    'user_id' => $user->id,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        return redirect()->route('admin.permissions.index', ['user_id' => $user->id])
                         ->with('success', 'Permisos asignados correctamente a ' . $user->name);
    }

    public function removeAll($id)
    {
        $user = User::findOrFail($id);
        DB::table('user_permission')->where('user_id', $user->id)->delete();

        return redirect()->route('admin.permissions.index', ['user_id' => $user->id])
                         ->with('success', 'Todos los permisos eliminados para ' . $user->name);
    }

    // 🔁 MÉTODO CORREGIDO PARA ELIMINAR PERMISOS SELECCIONADOS
    public function deleteSelected(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permissions' => 'required|array'
        ]);

        $user = User::findOrFail($request->user_id);

        foreach ($request->permissions as $permissionId) {
            DB::table('user_permission')
                ->where('user_id', $user->id)
                ->where('permission_id', $permissionId)
                ->delete();
        }

        return redirect()->route('admin.permissions.index', ['user_id' => $user->id])
                         ->with('success', 'Permisos seleccionados eliminados para ' . $user->name);
    }
}


