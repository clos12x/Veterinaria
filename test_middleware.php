<?php

require __DIR__ . '/vendor/autoload.php';

use App\Http\Middleware\IsCliente;

echo "Probando carga de IsCliente...\n";

if (class_exists(IsCliente::class)) {
    echo "✅ Laravel PUEDE cargar IsCliente.\n";
} else {
    echo "❌ Laravel NO puede cargar IsCliente.\n";
}
