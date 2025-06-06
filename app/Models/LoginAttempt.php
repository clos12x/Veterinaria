<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;

    // Nombre de la tabla si no sigue convención plural (opcional, pero recomendable)
    protected $table = 'login_attempts';

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'email',
        'attempts',
        'last_attempt',
        'blocked',
    ];

    // Casts automáticos
    protected $casts = [
        'blocked' => 'boolean',
        'last_attempt' => 'datetime',
    ];
}

