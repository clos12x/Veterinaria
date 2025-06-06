<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DireccionEnvio extends Model
{
    protected $table = 'direcciones_envio';
    protected $fillable = ['user_id', 'direccion', 'zona', 'ciudad', 'referencia', 'telefono'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
