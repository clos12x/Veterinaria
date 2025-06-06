<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $primaryKey = 'id_consulta';

    protected $fillable = [
        'descripcion',
        'fecha',
        'precio_consulta',
        'id_mascota',
        'id_empleado',
        'id_veterinario',
        'cobrado',
        'id_empleado_cobro',
        'fecha_cobro',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'id_mascota');
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'id_empleado');
    }

    public function veterinario()
    {
        return $this->belongsTo(User::class, 'id_veterinario');
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'id_consulta');
    }

    public function empleadoCobro()
{
    return $this->belongsTo(User::class, 'id_empleado_cobro');
}
}
