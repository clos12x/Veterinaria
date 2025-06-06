<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $fillable = ['nombre', 'edad', 'raza', 'id_cliente', 'id_tipoMascota'];

    public function tipo()
    {
        return $this->belongsTo(TipoMascota::class, 'id_tipoMascota');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_cliente');
    }

    public function consultas()
{
    return $this->hasMany(Consulta::class, 'id_mascota');
}
}