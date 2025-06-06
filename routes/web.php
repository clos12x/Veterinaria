<?php
use App\Http\Controllers\Admin\AdminReporteController;
use App\Http\Controllers\Empleado\VentaController;
use App\Http\Controllers\Empleado\ProductoController;
use App\Http\Controllers\Empleado\CategoriaController;
use App\Http\Controllers\Empleado\CobroConsultaController;
use App\Http\Controllers\Veterinario\ConsultaVeterinarioController;
use App\Http\Controllers\Empleado\ConsultaController;
use App\Http\Controllers\Empleado\DevolucionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\Empleado\TipoMascotaController;
use App\Http\Controllers\Empleado\MascotaController;
use App\Http\Controllers\Empleado\ProveedorController;
use App\Http\Controllers\VeterinarioController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Admin\CompraReporteController;
use App\Http\Controllers\AdminVeterinarioController;
use App\Http\Middleware\IsAdministrador;
use App\Http\Middleware\IsCliente;
use App\Http\Middleware\IsEmpleado;
use App\Http\Middleware\IsVeterinario;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Empleado\CompraController;
use App\Http\Controllers\Empleado\ServicioController;
use App\Http\Controllers\Admin\ReporteCompraController;
use App\Http\Controllers\Veterinario\PerfilVeterinarioController;
use App\Http\Controllers\Web\TiendaController;
use App\Http\Controllers\Web\CarritoController;
use App\Http\Controllers\Web\PagoController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Empleado\AjusteController;
use App\Http\Controllers\Cliente\DireccionEnvioController;
use App\Http\Controllers\Empleado\OrdenEnvioController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Cliente\HistorialController;



// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});
Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
// Rutas de autenticación social (Google y Facebook)
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [LoginController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [LoginController::class, 'handleFacebookCallback']);
// ----------------------
// Auth: Login & Register
// ----------------------
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']); // Registro como cliente

// ----------------------
// Recuperar contraseña
// ----------------------
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');
Route::post('/verificar-email', [RegisteredUserController::class, 'verificarEmail'])->name('verificar.email');
// ----------------------
// Redirección por rol
// ----------------------
Route::get('/dashboard', function () {
    return redirect('/redirect-by-role');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/redirect-by-role', function () {
    $role = auth()->user()->role ?? null;

    return match ($role) {
        'administrador' => redirect()->route('admin.dashboard'),
        'cliente' => redirect()->route('cliente.dashboard'),
        'veterinario' => redirect()->route('veterinario.dashboard'),
        'empleado' => redirect()->route('empleado.dashboard'),
        default => abort(403, 'Rol no autorizado'),
    };
});

// ----------------------
// Dashboards por rol
// ----------------------
Route::middleware(['auth', IsAdministrador::class])->get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::middleware(['auth', IsCliente::class])->get('/cliente/dashboard', [ClienteController::class, 'index'])->name('cliente.dashboard');
Route::middleware(['auth', IsVeterinario::class])->get('/veterinario/dashboard', [VeterinarioController::class, 'index'])->name('veterinario.dashboard');
Route::middleware(['auth', IsEmpleado::class])->get('/empleado/dashboard', [EmpleadoController::class, 'index'])->name('empleado.dashboard');
Route::middleware(['auth', IsAdministrador::class])->get('/admin/perfil', [AdminController::class, 'verPerfil'])->name('admin.verPerfil');
Route::middleware(['auth', IsCliente::class])->get('/cliente/perfil', [ClienteController::class, 'verPerfil'])->name('cliente.verPerfil');
Route::middleware(['auth', IsVeterinario::class])->get('/veterinario/perfil', [VeterinarioController::class, 'verPerfil'])->name('veterinario.verPerfil');
// ----------------------
Route::middleware(['auth', IsAdministrador::class])->get('/admin/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('cliente.edit');  // Ruta para editar cliente
Route::middleware(['auth', IsAdministrador::class])->put('/admin/clientes/{cliente}', [ClienteController::class, 'update'])->name('cliente.update');  // Ruta para actualizar cliente
Route::middleware(['auth', IsAdministrador::class])->delete('/admin/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('cliente.destroy');  // Ruta para eliminar cliente

// Veterinarios
Route::prefix('admin/veterinarios')->name('admin.veterinarios.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'verVeterinarios'])->name('index');
    Route::get('/crear', [AdminController::class, 'formularioVeterinario'])->name('crear');
    Route::post('/guardar', [AdminController::class, 'registrarVeterinario'])->name('guardar');
    Route::get('/{id}/editar', [AdminController::class, 'editarVeterinario'])->name('editar');
    Route::put('/{id}', [AdminController::class, 'actualizarVeterinario'])->name('actualizar');
    Route::delete('/{id}', [AdminController::class, 'eliminarVeterinario'])->name('eliminar');
});

// Usuarios bloqueados y desbloqueo (Admin)
// ----------------------
Route::middleware(['auth', IsAdministrador::class])->get('/admin/usuarios-bloqueados', [AdminController::class, 'desbloqueoUsuarios'])->name('admin.bloqueados');
Route::middleware(['auth', IsAdministrador::class])->post('/admin/desbloquear/{email}', [AdminController::class, 'desbloquear'])->name('admin.desbloquear');
//  Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
 Route::middleware(['auth', IsAdministrador::class])->get('/admin/panel', [AdminController::class, 'index'])->name('admin.panel');
Route::middleware(['auth', IsAdministrador::class])->get('/admin/clientes/ver', fn () => redirect()->route('admin.clientes'))->name('admin.verClientes');
Route::middleware(['auth', IsAdministrador::class])->get('/admin/veterinarios/ver', fn () => redirect()->route('admin.veterinarios'))->name('admin.verVeterinarios');
Route::middleware(['auth', IsAdministrador::class])->get('/admin/empleados/ver', fn () => redirect()->route('admin.empleados'))->name('admin.verEmpleados');
Route::middleware(['auth', IsAdministrador::class])->get('/admin/servicios/ver', fn () => redirect()->route('admin.servicios'))->name('admin.verServicios');
    Route::get('/perfil', [AdminController::class, 'verPerfil'])->name('verPerfil');
    Route::get('/usuarios-bloqueados', [AdminController::class, 'desbloqueoUsuarios'])->name('bloqueados');
    Route::post('/desbloquear/{email}', [AdminController::class, 'desbloquear'])->name('desbloquear');
 Route::get('/admin/empleados', [EmpleadoController::class, 'index'])->name('admin.empleados.index');
 Route::get('/admin/empleados', [AdminController::class, 'verEmpleados'])->name('admin.empleados.index');


Route::middleware(['auth', IsAdministrador::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/permisos', [RolePermissionController::class, 'index'])->name('permissions.index');
        Route::post('/permisos', [RolePermissionController::class, 'store'])->name('permissions.store');
        Route::post('/permisos/asignar', [RolePermissionController::class, 'assign'])->name('permissions.assign');
        Route::delete('/permisos/eliminar/{id}', [RolePermissionController::class, 'removeAll'])->name('permissions.eliminar');
        Route::post('/permisos/eliminar-seleccionados', [RolePermissionController::class, 'deleteSelected'])
            ->name('permissions.deleteSelected');


    });



    //administrador registra veterinario
    Route::get('/admin/registrar-veterinario', [AdminController::class, 'formularioVeterinario'])->name('admin.formularioVeterinario');
    Route::post('/admin/registrar-veterinario', [AdminController::class, 'registrarVeterinario'])->name('admin.registrarVeterinario');
    //administrador registra empleado
    Route::get('/admin/registrar-empleado', [AdminController::class, 'formularioEmpleado'])->name('admin.formularioEmpleado');
    Route::post('/admin/registrar-empleado', [AdminController::class, 'registrarEmpleado'])->name('admin.registrarEmpleado');
    //empleado registra cliente
    Route::get('/empleado/registrar-cliente', [EmpleadoController::class, 'formularioCliente'])->name('empleado.formularioCliente');
    Route::post('/empleado/registrar-cliente', [EmpleadoController::class, 'registrarCliente'])->name('empleado.registrarCliente');
    //empleado puede ver clientes
    Route::get('/empleado/clientes', [EmpleadoController::class, 'verClientes'])->name('empleado.verClientes');
    // Ver formulario de edición
    Route::get('/empleado/clientes/{id}/editar', [EmpleadoController::class, 'editarCliente'])->name('empleado.editarCliente');

    // Actualizar cliente
    Route::post('/empleado/clientes/{id}/actualizar', [EmpleadoController::class, 'actualizarCliente'])->name('empleado.actualizarCliente');

    // Eliminar cliente
    Route::delete('/empleado/clientes/{id}', [EmpleadoController::class, 'eliminarCliente'])->name('empleado.eliminarCliente');
    //admin a veterinario y empleado
    Route::get('/admin/ver-veterinarios', [AdminController::class, 'verVeterinarios'])->name('admin.verVeterinarios');
    Route::get('/admin/ver-empleados', [AdminController::class, 'verEmpleados'])->name('admin.verEmpleados');
    // Clientes (Admin)
Route::middleware(['auth', IsAdministrador::class])->group(function () {
    // Ver todos los clientes
    Route::get('/admin/clientes', [AdminController::class, 'verClientes'])->name('admin.clientes');

    // Editar cliente
    Route::get('/admin/clientes/{id}/editar', [AdminController::class, 'editarCliente'])->name('admin.editarCliente');
    
    // Actualizar cliente
    Route::put('/admin/clientes/{id}', [AdminController::class, 'actualizarCliente'])->name('admin.actualizarCliente');
    
    // Eliminar cliente
    Route::delete('/admin/clientes/{id}', [AdminController::class, 'eliminarCliente'])->name('admin.eliminarCliente');
});

    // Veterinarios editar, eliminar
Route::get('/admin/veterinarios/{id}/editar', [AdminController::class, 'editarVeterinario'])->name('admin.editarVeterinario');
// Route::put('/admin/veterinarios/{id}', [AdminController::class, 'actualizarVeterinario'])->name('admin.actualizarVeterinario');
Route::delete('/admin/veterinarios/{id}', [AdminController::class, 'eliminarVeterinario'])->name('admin.eliminarVeterinario');

// Empleados editar, eliminar
Route::get('/admin/empleados/{id}/editar', [AdminController::class, 'editarEmpleado'])->name('admin.editarEmpleado');
Route::put('/admin/empleados/{id}', [AdminController::class, 'actualizarEmpleado'])->name('admin.actualizarEmpleado');
Route::delete('/admin/empleados/{id}', [AdminController::class, 'eliminarEmpleado'])->name('admin.eliminarEmpleado');
// Ver perfil del empleado
    Route::get('/empleado/perfil', [EmpleadoController::class, 'perfil'])->name('empleado.perfil');
    Route::get('/empleado/perfil/editar', [EmpleadoController::class, 'editarPerfil'])->name('empleado.editarPerfil');
    Route::put('/empleado/perfil/actualizar', [EmpleadoController::class, 'actualizarPerfil'])->name('empleado.actualizarPerfil');
//es para volver al panel empleado 
Route::get('/empleado/panel', [EmpleadoController::class, 'index'])->name('empleado.panel');
Route::get('/empleado', [EmpleadoController::class, 'index'])->name('empleado.index');
Route::get('/admin/panel', [AdminController::class, 'index'])->name('admin.panel');


// Tipo de mascota
Route::prefix('empleado/tipos-mascotas')->name('empleado.tipoMascota.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Empleado\TipoMascotaController::class, 'index'])->name('index');
    Route::get('/crear', [\App\Http\Controllers\Empleado\TipoMascotaController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Empleado\TipoMascotaController::class, 'store'])->name('store');
    Route::delete('/{id}', [\App\Http\Controllers\Empleado\TipoMascotaController::class, 'destroy'])->name('destroy');
});

// Mascotas
Route::prefix('empleado/mascotas')->name('empleado.mascota.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Empleado\MascotaController::class, 'index'])->name('index');
    Route::get('/crear', [\App\Http\Controllers\Empleado\MascotaController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Empleado\MascotaController::class, 'store'])->name('store');
});

Route::get('/empleado/mascotas', [MascotaController::class, 'buscarMascotas'])->name('empleado.mascota.index');





Route::prefix('empleado/consultas')->middleware('auth')->group(function () {
    Route::get('/crear', [ConsultaController::class, 'create'])->name('empleado.consulta.create');
    Route::post('/guardar', [ConsultaController::class, 'store'])->name('empleado.consulta.store');
});

Route::prefix('veterinario/consultas')->name('veterinario.consulta.')->middleware('auth')->group(function () {
    Route::get('/', [ConsultaVeterinarioController::class, 'index'])->name('index');
    Route::get('/{id}/agregar-servicio', [ConsultaVeterinarioController::class, 'formularioServicio'])->name('servicio.create');
    Route::post('/{id}/guardar-servicio', [ConsultaVeterinarioController::class, 'guardarServicio'])->name('servicio.store');
});

Route::prefix('empleado/cobros')->name('empleado.cobros.')->middleware('auth')->group(function () {
    Route::get('/', [CobroConsultaController::class, 'index'])->name('index');
    Route::post('/{id}/cobrar', [CobroConsultaController::class, 'cobrar'])->name('cobrar');
    Route::get('/{id}/recibo', [CobroConsultaController::class, 'recibo'])->name('recibo');
});
//categoria
Route::prefix('empleado/categorias')->name('empleado.categorias.')->middleware('auth')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index');
    Route::get('/crear', [CategoriaController::class, 'create'])->name('create');
    Route::post('/guardar', [CategoriaController::class, 'store'])->name('store');
    Route::get('/{id}/editar', [CategoriaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CategoriaController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoriaController::class, 'destroy'])->name('destroy');
});
//producto
Route::prefix('empleado/productos')->name('empleado.productos.')
    ->middleware(['auth', IsEmpleado::class]) 
    // ->middleware(['auth', 'rol:empleado,administrador'])
    ->group(function () {

    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/crear', [ProductoController::class, 'create'])->name('create');
    Route::post('/guardar', [ProductoController::class, 'store'])->name('store');
    Route::get('/{id}/editar', [ProductoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProductoController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductoController::class, 'destroy'])->name('destroy');

});

//venta
Route::prefix('empleado/ventas')->name('empleado.ventas.')->middleware('auth')->group(function () {
    Route::get('/crear', [VentaController::class, 'create'])->name('create');
    Route::post('/agregar', [VentaController::class, 'agregarProducto'])->name('agregarProducto');
    Route::get('/carrito', [VentaController::class, 'verCarrito'])->name('carrito');
    Route::post('/confirmar', [VentaController::class, 'confirmarVenta'])->name('confirmar');
    Route::get('/{id}/recibo', [VentaController::class, 'recibo'])->name('recibo');
    Route::post('/carrito/eliminar/{id_producto}', [VentaController::class, 'eliminarProducto'])->name('carrito.eliminar');
    Route::post('/carrito/actualizar/{id_producto}', [VentaController::class, 'actualizarCantidad'])->name('carrito.actualizar');
    Route::get('/', [VentaController::class, 'index'])->name('index'); // ✅ Correcto
});
    //reportes
    Route::get('/reportes', [AdminReporteController::class, 'index'])->name('admin.reportes.index');
    Route::get('/reportes/pdf', [AdminReporteController::class, 'descargarPdf'])->name('admin.reportes.descargarPdf');
    // Route::get('/reporte-compras', [AdminReporteController::class, 'reporteCompras'])->name('admin.reporteCompras');

    //almacen
    Route::prefix('empleado/almacenes')->name('empleado.almacen.')->middleware('auth')->group(function () {
        Route::get('/', [\App\Http\Controllers\Empleado\AlmacenController::class, 'index'])->name('index');
        Route::get('/crear', [\App\Http\Controllers\Empleado\AlmacenController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Empleado\AlmacenController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [\App\Http\Controllers\Empleado\AlmacenController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Empleado\AlmacenController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Empleado\AlmacenController::class, 'destroy'])->name('destroy');
    });
    //stock
    Route::prefix('empleado/stock')->name('empleado.stock.')->middleware('auth')->group(function () {
        Route::get('/crear', [\App\Http\Controllers\Empleado\StockController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Empleado\StockController::class, 'store'])->name('store');
    });
    Route::get('empleado/almacenes/stock', [App\Http\Controllers\Empleado\StockController::class, 'verStock'])->name('empleado.almacenes.stock');
    Route::prefix('empleado/stockbajo')->name('empleado.stockbajo.')->middleware('auth')->group(function () {
        Route::get('/', [\App\Http\Controllers\Empleado\StockBajoController::class, 'index'])->name('index');
    });

    Route::get('empleado/almacenes/transferir', [App\Http\Controllers\Empleado\StockController::class, 'formularioTransferir'])->name('empleado.almacenes.transferir');
    Route::post('empleado/almacenes/transferir', [App\Http\Controllers\Empleado\StockController::class, 'realizarTransferencia'])->name('empleado.almacenes.transferir.store');

    Route::prefix('empleado/movimientos')->name('empleado.movimientos.')->middleware('auth')->group(function () {
        Route::get('/', [\App\Http\Controllers\Empleado\MovimientoController::class, 'index'])->name('index');
    });
    Route::prefix('empleado/compras')->name('empleado.compras.')->middleware('auth')->group(function () {
        Route::get('/', [CompraController::class, 'index'])->name('index');
        Route::get('/crear', [CompraController::class, 'create'])->name('create');
        Route::post('/guardar', [CompraController::class, 'store'])->name('store');
       
    });
     //admin
    // Route::prefix('admin/compras')->name('admin.compras.')->middleware('auth')->group(function () {
    //     Route::get('/reporte/pdf', [ReporteCompraController::class, 'descargarPdf'])->name('reporte.pdf');
    // });
    Route::prefix('admin/compras')->name('admin.compras.')->middleware('auth')->group(function () {
        Route::get('/reporte', [CompraReporteController::class, 'index'])->name('reporte');
        Route::get('/reporte/pdf', [CompraReporteController::class, 'pdf'])->name('reporte.pdf');
    });
    Route::prefix('admin/reportes')->name('admin.reportes.')->middleware('auth')->group(function () {
    Route::get('/', [AdminReporteController::class, 'index'])->name('index');
    Route::get('/pdf', [AdminReporteController::class, 'descargarPdf'])->name('pdf');
});
    // Route::get('/reportes', [AdminController::class, 'reportes'])->name('reportes');
    // Route::get('/reportes', [AdminController::class, 'vistaReportes'])->name('reportes');

    //Proveedor
    Route::prefix('empleado/proveedores')->name('empleado.proveedores.')->middleware('auth')->group(function () {
        Route::get('/', [ProveedorController::class, 'index'])->name('index');
        Route::get('/crear', [ProveedorController::class, 'create'])->name('create');
        Route::post('/', [ProveedorController::class, 'store'])->name('store');
        Route::get('/{proveedor}/editar', [ProveedorController::class, 'edit'])->name('edit');
        Route::put('/{proveedor}', [ProveedorController::class, 'update'])->name('update');
        Route::delete('/{proveedor}', [ProveedorController::class, 'destroy'])->name('destroy');
    });
    Route::get('/compras/{id}', [CompraController::class, 'show'])->name('empleado.compras.show');

    //devoluciones
    Route::prefix('empleado/devoluciones')->name('empleado.devoluciones.')->middleware('auth')->group(function () {
        Route::get('/', [DevolucionController::class, 'index'])->name('index');
        Route::get('/crear', [DevolucionController::class, 'create'])->name('create');
        Route::post('/', [DevolucionController::class, 'store'])->name('store');
         Route::post('/multiple', [DevolucionController::class, 'storeMultiple'])->name('store.multiple');
    });
       //tienda cliente
   // Cliente - tienda y carrito
   Route::get('/tienda', [TiendaController::class, 'index'])->name('tienda.index');

   Route::prefix('tienda')->name('web.')->group(function () {
       Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
       Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
       Route::post('/carrito/eliminar/{id_producto}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
       Route::post('/carrito/actualizar/{id_producto}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
       Route::post('/carrito/comprar', [CarritoController::class, 'comprar'])->middleware('auth')->name('web.carrito.comprar');
   });
   Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/dashboard/cliente', function () {
        return view('dashboard.cliente');
    })->name('dashboard.cliente');
    });

    Route::middleware(['auth'])->group(function () {
        // Route::post('/carrito/comprar', [App\Http\Controllers\Web\CarritoController::class, 'confirmarCompra'])->name('web.carrito.comprar');
        Route::get('/carrito/recibo/{id}', [App\Http\Controllers\Web\CarritoController::class, 'verRecibo'])->name('web.carrito.recibo');
    });


Route::get('/admin/reporte', [AdminReporteController::class, 'verReporte'])->name('admin.reporte');
Route::get('/admin/reporte-pdf', [AdminReporteController::class, 'verReportePDF'])->name('admin.reporte_pdf');

Route::middleware(['auth'])->prefix('veterinario')->name('veterinario.')->group(function () {
    Route::get('/dashboard', [VeterinarioController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [VeterinarioController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [VeterinarioController::class, 'actualizarPerfil'])->name('perfil.update');
});
///////para eliminar y editar permisos////admin
// Route::get('/admin/permisos', [RolePermissionController::class, 'index'])->name('admin.permisos.index');
// Route::post('/admin/permisos/asignar', [RolePermissionController::class, 'assign'])->name('admin.permisos.asignar');
// Route::delete('/admin/permisos/eliminar/{id}', [RolePermissionController::class, 'removeAll'])->name('admin.permisos.eliminar');


    //ajustes
    Route::prefix('empleado/ajustes')->name('empleado.ajustes.')->middleware('auth')->group(function () {
    Route::get('/crear', [AjusteController::class, 'create'])->name('create');
    Route::post('/', [AjusteController::class, 'store'])->name('store');
   
    
});
Route::get('/api/productos', [AjusteController::class, 'buscarProductos'])->name('api.productos');
 Route::get('/empleado/ajustes', [AjusteController::class, 'index'])->name('empleado.ajustes.index')->middleware('auth');

 Route::middleware(['auth'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('direccion', [\App\Http\Controllers\Cliente\DireccionEnvioController::class, 'index'])->name('direccion.index');
    Route::post('direccion', [\App\Http\Controllers\Cliente\DireccionEnvioController::class, 'store'])->name('direccion.store');
});
// cliente actualizar sus datos  para el envio
Route::middleware(['auth'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/direccion', [DireccionEnvioController::class, 'index'])->name('direccion.index');
    Route::post('/direccion', [DireccionEnvioController::class, 'store'])->name('direccion.store');
    Route::put('/direccion/{direccion}', [DireccionEnvioController::class, 'update'])->name('direccion.update');
    Route::delete('/direccion/{direccion}', [DireccionEnvioController::class, 'destroy'])->name('direccion.destroy');
});

//empleado de ordenes
//Route::middleware(['auth'])->prefix('empleado/ordenes')->name('empleado.ordenes.')->group(function () {
 //   Route::get('/', [\App\Http\Controllers\Empleado\OrdenEnvioController::class, 'index'])->name('index');
  //  Route::put('/{orden}/estado', [\App\Http\Controllers\Empleado\OrdenEnvioController::class, 'cambiarEstado'])->name('estado');
//});
Route::prefix('empleado/ordenes')->name('empleado.ordenes.')->middleware('auth')->group(function () {
    Route::get('/', [OrdenEnvioController::class, 'index'])->name('index');
    Route::put('/{id}/estado', [OrdenEnvioController::class, 'actualizarEstado'])->name('actualizarEstado');
    
});
Route::get('/empleado/ordenes/{orden}/recibo', [OrdenEnvioController::class, 'verRecibo'])->name('empleado.ordenes.recibo');
Route::get('/empleado/ordenes/{orden}/recibo-pdf', [OrdenEnvioController::class, 'descargarReciboPDF'])->name('empleado.ordenes.recibo.pdf');
/////metodo de pagos/////

// Route::get('/tienda/metodo-pago/{ventaId}', [PagoController::class, 'mostrarFormulario'])->name('tienda.pago.formulario');
Route::post('/tienda/pago-registrar', [PagoController::class, 'registrar'])->name('tienda.pago.registrar');
Route::post('/pago/guardar', [PagoController::class, 'store'])->name('pago.store');
// Route::get('/carrito/confirmar', [CarritoController::class, 'confirmarCompra'])->name('web.carrito.confirmarCompra');
Route::post('/carrito/confirmar', [CarritoController::class, 'confirmarCompra'])->name('web.carrito.confirmarCompra');
Route::post('/carrito/forma-pago', [CarritoController::class, 'irFormaPago'])->name('web.carrito.irFormaPago');
Route::post('/carrito/pago', [CarritoController::class, 'pago'])->name('web.carrito.pago');
Route::get('/tienda/metodo-pago/{ventaId}', [PagoController::class, 'mostrarFormulario'])->name('tienda.pago.formulario');

Route::post('/carrito/forma-pago', [CarritoController::class, 'irFormaPago'])
    ->middleware('auth')
    ->name('web.carrito.irFormaPago');

Route::get('/carrito/forma-pago', function () {
    return view('tienda.forma_pago'); // asegúrate que exista esa vista
})->name('web.carrito.formaPagoVista');


//historial
Route::middleware(['auth'])->group(function () {
    Route::get('/cliente/historial', [HistorialController::class, 'index'])->name('cliente.historial.index');
});

Route::get('/cliente/dashboard', [ClienteController::class, 'index'])->name('cliente.dashboard');