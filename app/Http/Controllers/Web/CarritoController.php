<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\OrdenEnvio;
use App\Models\Pago;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        return view('tienda.carrito', compact('carrito'));
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->id_producto);
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$producto->id])) {
            $carrito[$producto->id]['cantidad'] += $request->cantidad;
        } else {
            $carrito[$producto->id] = [
                'id_producto' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => $request->cantidad,
            ];
        }

        session(['carrito' => $carrito]);
        return redirect()->route('web.carrito.index')->with('success', 'Producto agregado al carrito.');
    }

    public function eliminar($id_producto)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id_producto])) {
            unset($carrito[$id_producto]);
            session(['carrito' => $carrito]);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function actualizar(Request $request, $id_producto)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $carrito = session()->get('carrito', []);
        if (isset($carrito[$id_producto])) {
            $carrito[$id_producto]['cantidad'] = $request->cantidad;
            session(['carrito' => $carrito]);
        }

        return back()->with('success', 'Cantidad actualizada.');
    }
//
    public function irFormaPago(Request $request)
{
    $carrito = session('carrito', []);
    if (empty($carrito)) {
        return redirect()->route('tienda.index')->with('error', 'El carrito está vacío.');
    }

    session([
        'tipo_entrega' => $request->tipo_entrega,
        'direccion_envio_id' => $request->direccion_envio_id ?? null,
    ]);

    return view('tienda.forma_pago', [
        'ventaId' => null,
        'carrito' => $carrito,
    ]);
}
//
    public function confirmarCompra(Request $request)
    {
        $carrito = session('carrito', []);
        if (empty($carrito)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        $request->validate([
            'metodo' => 'required|in:tarjeta,transferencia',
            'referencia' => $request->metodo === 'transferencia' ? 'required|string|max:100' : 'nullable|string|max:100',
            'nombre_titular' => 'nullable|string|max:255',
            'numero_tarjeta' => 'nullable|string|max:20',
            'fecha_vencimiento' => 'nullable|string|max:7',
            'cvv' => 'nullable|string|max:4',
            'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $total = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);

            $venta = Venta::create([
                'id_cliente' => Auth::id(),
                'fecha' => now(),
                'total' => $total,
                'metodo_pago' => $request->metodo,
            ]);

            foreach ($carrito as $item) {
                $almacenProducto = DB::table('almacen_producto')
                    ->where('id_producto', $item['id_producto'])
                    ->orderBy('stock', 'desc')
                    ->lockForUpdate()
                    ->first();

                if (!$almacenProducto || $almacenProducto->stock < $item['cantidad']) {
                    DB::rollBack();
                    return back()->with('error', 'Stock insuficiente para ' . $item['nombre']);
                }

                DB::table('almacen_producto')->where('id', $almacenProducto->id)->update([
                    'stock' => $almacenProducto->stock - $item['cantidad'],
                ]);

                DetalleVenta::create([
                    'id_venta' => $venta->id,
                    'id_producto' => $item['id_producto'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);
            }

            $pago = new Pago();
            $pago->venta_id = $venta->id;
            $pago->metodo = $request->metodo;

            if ($request->metodo === 'tarjeta') {
                $pago->nombre_titular = $request->nombre_titular;
                $pago->numero_tarjeta = $request->numero_tarjeta;
                $pago->expiracion = $request->fecha_vencimiento;
                $pago->cvv = $request->cvv;
                $pago->referencia = null;
            } else {
                $pago->referencia = $request->referencia;
                if ($request->hasFile('comprobante')) {
                    $pago->comprobante = $request->file('comprobante')->store('comprobantes', 'public');
                }
            }

            $pago->save();

            $tipoEntrega = session('tipo_entrega', 'retiro');
            $direccionId = session('direccion_envio_id');

            if ($tipoEntrega === 'delivery' && !$direccionId) {
                DB::rollBack();
                return back()->with('error', 'Debe seleccionar una dirección válida para delivery.');
            }

            OrdenEnvio::create([
                'id_venta' => $venta->id,
                'estado' => 'pendiente',
                'tipo_entrega' => $tipoEntrega,
                'direccion_envio_id' => $tipoEntrega === 'delivery' ? $direccionId : null,
            ]);

            session()->forget(['carrito', 'tipo_entrega', 'direccion_envio_id']);

            DB::commit();

            return redirect()->route('web.carrito.recibo', $venta->id)
                ->with('success', '✅ Compra, pago y orden registrados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al realizar la compra: ' . $e->getMessage());
        }
    }

    public function irFormaPagoVista()
    {
        return view('tienda.forma_pago'); // Vista de formulario de pago
    }

    public function verRecibo($id)
    {
        $venta = Venta::with('detalles.producto')
            ->where('id', $id)
            ->where('id_cliente', Auth::id())
            ->firstOrFail();

        return view('tienda.recibo', compact('venta'));
    }
}
