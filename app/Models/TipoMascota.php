<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMascota extends Model
{
    protected $primaryKey = 'id_tipoMascota';
    protected $fillable = ['nombre'];
    protected $table = 'tipo_mascotas';

    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'id_tipoMascota');
    }
}