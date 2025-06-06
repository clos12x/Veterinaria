<div id="sidebar" class="sidebar">
  @if(auth()->user()->hasPermission('cliente'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-users me-2"></i> Clientes</div>
    <div class="submenu">
      <a href="{{ route('empleado.formularioCliente') }}">Registrar Cliente</a>
      <a href="{{ route('empleado.verClientes') }}">Ver Clientes</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('mascota'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-dog me-2"></i> Mascotas</div>
    <div class="submenu">
      <a href="{{ route('empleado.tipoMascota.create') }}">Registrar Tipo de Mascota</a>
      <a href="{{ route('empleado.mascota.create') }}">Registrar Mascota</a>
      <a href="{{ route('empleado.tipoMascota.index') }}">Ver Tipos de Mascotas</a>
      <a href="{{ route('empleado.mascota.index') }}">Ver Mascotas</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('consulta'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-file-medical me-2"></i> Consultas</div>
    <div class="submenu">
      <a href="{{ route('empleado.consulta.create') }}">Registrar Consulta</a>
      <a href="{{ route('empleado.cobros.index') }}">Cobros</a>
      <a href="{{ route('empleado.consulta.create') }}">Ver Consultas</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('categoria'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-folder me-2"></i> Categorías</div>
    <div class="submenu">
      <a href="{{ route('empleado.categorias.create') }}">Registrar Categoría</a>
      <a href="{{ route('empleado.categorias.index') }}">Ver Categorías</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('producto'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-box me-2"></i> Productos</div>
    <div class="submenu">
      <a href="{{ route('empleado.productos.create') }}">Registrar Producto</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('almacen'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-warehouse me-2"></i> Almacén</div>
    <div class="submenu">
      <a href="{{ route('empleado.almacen.create') }}">Registrar Almacén</a>
      <a href="{{ route('empleado.almacenes.stock') }}">Ver Stock</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('stock'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-boxes-stacked me-2"></i> Stock</div>
    <div class="submenu">
      <a href="{{ route('empleado.stock.create') }}">Registrar Stock</a>
      <a href="{{ route('empleado.almacenes.transferir') }}">Transferir</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('venta'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-shopping-cart me-2"></i> Ventas</div>
    <div class="submenu">
      <a href="{{ route('empleado.ventas.create') }}">Registrar Venta</a>
      <a href="{{ route('empleado.ventas.index') }}">Ver Ventas</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('proveedor'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-truck me-2"></i> Proveedores</div>
    <div class="submenu">
      <a href="{{ route('empleado.proveedores.create') }}">Registrar Proveedor</a>
      <a href="{{ route('empleado.proveedores.index') }}">Ver Proveedores</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('compra'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-file-invoice-dollar me-2"></i> Compras</div>
    <div class="submenu">
      <a href="{{ route('empleado.compras.create') }}">Registrar Compra</a>
      <a href="{{ route('empleado.compras.index') }}">Ver Compras</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('movimientos'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-right-left me-2"></i> Movimientos</div>
    <div class="submenu">
      <a href="{{ route('empleado.movimientos.index') }}">Ver Movimientos</a>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('devolucion'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-undo me-2"></i> Devoluciones</div>
    <div class="submenu">
      <a href="{{ route('empleado.devoluciones.create') }}">Registrar Devolución</a>
      <a href="{{ route('empleado.devoluciones.index') }}">Ver Devoluciones</a>
    </div>
  </div>
  @endif
</div>
