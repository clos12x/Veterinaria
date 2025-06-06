<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajuste extends Model
{
    protected $fillable = [
        'id_producto', 'id_almacen', 'tipo', 'cantidad', 'glosa', 'fecha', 'id_usuario'
    ];

    public function producto() {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function almacen() {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }

    public function usuario() {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}