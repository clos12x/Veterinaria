<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = ['nombre', 'precio', 'id_consulta'];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'id_consulta');
    }
}