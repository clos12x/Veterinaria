<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'venta_id',
        'metodo',
        'referencia',
        'nombre_titular',
        'numero_tarjeta',
        'expiracion',
        'cvv',
        'comprobante', // 🆕 agregado
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}

