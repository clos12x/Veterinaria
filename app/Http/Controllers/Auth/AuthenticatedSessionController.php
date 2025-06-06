<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $loginAttempt = LoginAttempt::firstOrNew(['email' => $request->email]);

    if ($loginAttempt->blocked) {
        $now = now();
        $minutesSinceLast = Carbon::parse($loginAttempt->last_attempt ?? $now)->diffInMinutes($now);

        if ($minutesSinceLast >= 10) {
            $loginAttempt->update([
                'attempts' => 0,
                'blocked' => false,
                'last_attempt' => null
            ]);
        } else {
            return back()->withErrors([
                'email' => "⛔ Tu cuenta está bloqueada. Intenta en " . (10 - $minutesSinceLast) . " minuto(s).",
            ])->onlyInput('email');
        }
    }

    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        $loginAttempt->increment('attempts');
        $loginAttempt->last_attempt = now();

        if ($loginAttempt->attempts >= 3) {
            $loginAttempt->blocked = true;
        }

        $loginAttempt->save();

        return back()->withErrors([
            'password' => '❌ La contraseña ingresada no es válida.',
        ])->onlyInput('email');
    }

    $loginAttempt->delete();
    $request->session()->regenerate();

    $user = Auth::user();

    // ✅ Si es nuevo empleado o veterinario y aún no tiene permisos asignados
    $tienePermisos = DB::table('user_permission')->where('user_id', $user->id)->exists();

    if (!$tienePermisos && in_array($user->role, ['empleado', 'veterinario'])) {
    $todos = Permission::all();

foreach ($todos as $permiso) {
    DB::table('user_permission')->insert([
        'user_id' => $user->id,
        'permission_id' => $permiso->id
    ]);
}
    }

// ✅ Solo si este usuario tiene permiso especial, ir a admin temporalmente
if ($user->hasPermission('administrador_total') && in_array($user->role, ['empleado', 'veterinario'])) {
    return redirect()->route('admin.dashboard');
}

    // 🚦 Redirección según rol
    return match ($user->role) {
        'administrador' => redirect()->route('admin.dashboard'),
        'cliente' => redirect()->route('cliente.dashboard'),
        'veterinario' => redirect()->route('veterinario.dashboard'),
        'empleado' => redirect()->route('empleado.dashboard'),
        default => abort(403),
    };
}

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
