<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlmacenProducto;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Movimiento; 
use App\Models\User;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function create(Request $request)
    {
        $idAlmacen = $request->input('id_almacen');

        $almacenes = DB::table('almacenes')->get();
        $productos = [];

        if ($idAlmacen) {
            $productos = DB::table('almacen_producto')
                ->join('productos', 'productos.id', '=', 'almacen_producto.id_producto')
                ->join('almacenes', 'almacenes.id', '=', 'almacen_producto.id_almacen')
                ->where('almacen_producto.stock', '>', 0)
                ->where('almacen_producto.id_almacen', $idAlmacen)
                ->select(
                    'productos.id as id_producto',
                    'productos.nombre',
                    'productos.precio',
                    'productos.imagen',
                    'almacen_producto.stock',
                    'almacenes.id as id_almacen',
                    'almacenes.nombre as nombre_almacen'
                )
                ->get();
        }

        $clientes = User::where('role', 'cliente')->get();

        return view('empleado.venta.create', compact('almacenes', 'productos', 'clientes', 'idAlmacen'));
    }

    public function agregarProducto(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->id_producto);

        $almacenProducto = DB::table('almacen_producto')
            ->where('id_producto', $producto->id)
            ->first();

        if (!$almacenProducto) {
            return back()->with('error', 'El producto no está en ningún almacén.');
        }

        if ($request->cantidad > $almacenProducto->stock) {
            return back()->with('error', 'Stock insuficiente en el almacén.');
        }

        $carrito = session()->get('carrito', []);

        $carrito[$producto->id] = [
            'id_producto' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'cantidad' => ($carrito[$producto->id]['cantidad'] ?? 0) + $request->cantidad
        ];

        session(['carrito' => $carrito]);

        return redirect()->route('empleado.ventas.carrito')->with('success', 'Producto agregado al carrito.');
    }

    public function verCarrito()
    {
        $carrito = session()->get('carrito', []);
        $clientes = User::where('role', 'cliente')->get();

        foreach ($carrito as $id => &$item) {
            $stockIntermedio = DB::table('almacen_producto')
                ->where('id_producto', $id)
                ->sum('stock');

            $item['stock_actual'] = $stockIntermedio ?? 0;
        }
        unset($item);

        return view('empleado.venta.carrito', compact('carrito', 'clientes'));
    }

    public function confirmarVenta(Request $request)
    {
        $request->validate([
            'id_cliente' => 'nullable|exists:users,id',
        ]);

        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        DB::beginTransaction();

        try {
            $total = 0;

            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            $venta = Venta::create([
                'id_cliente' => $request->id_cliente,
                'total' => $total,
                'fecha' => now(),
            ]);

            foreach ($carrito as $item) {
                $almacenProducto = DB::table('almacen_producto')
                    ->where('id_producto', $item['id_producto'])
                    ->lockForUpdate()
                    ->first();

                if (!$almacenProducto || $almacenProducto->stock < $item['cantidad']) {
                    DB::rollBack();
                    return back()->with('error', 'Stock insuficiente para ' . $item['nombre']);
                }

                DB::table('almacen_producto')
                    ->where('id', $almacenProducto->id)
                    ->update([
                        'stock' => $almacenProducto->stock - $item['cantidad']
                    ]);

                DetalleVenta::create([
                    'id_venta' => $venta->id,
                    'id_producto' => $item['id_producto'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);

                Movimiento::create([
                    'id_producto' => $item['id_producto'],
                    'id_almacen' => $almacenProducto->id_almacen ?? null,
                    'id_usuario' => auth()->id(),
                    'tipo' => 'salida',
                    'cantidad' => $item['cantidad'],
                    'detalle' => 'Venta realizada'
                ]);
            }

        // al final del try justo antes del commit
if (auth()->check() && auth()->user()->role === 'cliente') {
    DB::commit();
    session()->forget('carrito');
    return redirect()->route('cliente.pago', $venta->id);
}

DB::commit();
session()->forget('carrito');

return redirect()->route('empleado.ventas.recibo', $venta->id)->with('success', 'Venta registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar venta: ' . $e->getMessage());
        }
    }

    public function recibo($id)
    {
        $venta = Venta::with('detalles.producto')->findOrFail($id);
        return view('empleado.venta.recibo', compact('venta'));
    }

    public function eliminarProducto($id_producto)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id_producto])) {
            unset($carrito[$id_producto]);
            session(['carrito' => $carrito]);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function actualizarCantidad(Request $request, $id_producto)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id_producto])) {
            $stockDisponible = DB::table('almacen_producto')
                ->where('id_producto', $id_producto)
                ->sum('stock');

            if ($request->cantidad > $stockDisponible) {
                return back()->with('error', 'No hay suficiente stock disponible.');
            }

            $carrito[$id_producto]['cantidad'] = $request->cantidad;
            session(['carrito' => $carrito]);
        }

        return back()->with('success', 'Cantidad actualizada.');
    }

    public function index()
    {
        $ventas = Venta::with('detalles.producto')->orderBy('fecha', 'desc')->get();
        return view('empleado.venta.index', compact('ventas'));
    }


}
