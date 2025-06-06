<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $fillable = ['id_venta', 'id_producto', 'cantidad', 'precio_unitario'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
