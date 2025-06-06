<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    protected $table = 'devoluciones';
    protected $fillable = ['id_venta', 'id_producto', 'cantidad', 'motivo', 'id_usuario'];

    public function producto() {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function venta() {
        return $this->belongsTo(Venta::class, 'id_venta');
    }

    public function usuario() {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}