<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
        'id_proveedor',
        'id_almacen',
        'fecha',
        'total',
    ];
    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'id_compra');
    }
    public function almacen()
{
    return $this->belongsTo(\App\Models\Almacen::class, 'id_almacen');
}
}