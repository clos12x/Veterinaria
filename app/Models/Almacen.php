<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = 'almacenes'; // ✅ Corrige el nombre de tabla

    protected $fillable = [
        'nombre',
        'ubicacion',
    ]; // ✅ Define qué campos se pueden guardar masivamente
    public function productos()
{
    return $this->belongsToMany(Producto::class, 'almacen_producto', 'id_almacen', 'id_producto')
                ->withPivot('stock')
                ->withTimestamps();
}
}