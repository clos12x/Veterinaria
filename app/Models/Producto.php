<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'precio',
        'id_categoria',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
    public function almacenes()
{
    return $this->belongsToMany(Almacen::class, 'almacen_producto', 'id_producto', 'id_almacen')
        ->withPivot('stock')
        ->withTimestamps();
}

}