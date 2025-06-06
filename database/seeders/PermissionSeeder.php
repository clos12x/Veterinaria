<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modulos = [
            'clientes','almacen', 'categoria', 'cobro', 'compra', 'consulta', 'devolucion',
            'mascota', 'movimientos', 'producto', 'proveedor', 'servicio',
            'stock', 'stockbajo', 'tipo-mascota', 'tipo-servicio', 'venta','Ajustes','Pagos',
            'ordenes',
             // ✅ Permiso especial para dar acceso total como administrador
            'administrador_total'
        ];

        foreach ($modulos as $modulo) {
            Permission::firstOrCreate([
                'name' => $modulo,
            ], [
                'description' => 'Permiso para acceder al módulo de ' . ucfirst(str_replace('-', ' ', $modulo)),
            ]);
        }
    }
}
