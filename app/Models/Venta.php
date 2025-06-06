<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['id_cliente', 'total', 'fecha'];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }
    
        public function cliente()
    {
    return $this->belongsTo(User::class, 'id_cliente');
    }

    public function pago()
{
    return $this->hasOne(Pago::class);
}

}
