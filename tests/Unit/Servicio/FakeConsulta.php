<?php

namespace Tests\Unit\Servicio;

use App\Models\Consulta as BaseConsulta;

class FakeConsulta extends BaseConsulta
{
    protected $primaryKey = 'id_consulta';
    public $incrementing = false; // ⚠️ muy importante para forzar ID en SQLite
    protected $keyType = 'int';
    public $timestamps = false; // ⚠️ evita errores con updated_at y created_at
}
