<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenEnvio extends Model
{
    protected $table = 'ordenes_envio';
    protected $fillable = ['id_venta', 'tipo_entrega', 'direccion_envio_id', 'estado'];

        public function direccion()
        {
            return $this->belongsTo(DireccionEnvio::class, 'direccion_envio_id');
        }

        public function venta()
        {
            return $this->belongsTo(Venta::class, 'id_venta');
        }
        public function detalles()
            {
                return $this->hasMany(DetalleVenta::class);
            }
        
}
