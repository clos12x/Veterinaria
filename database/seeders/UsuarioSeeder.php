<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Administrador',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'role' => 'administrador',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cliente',
                'email' => 'cliente@cliente.com',
                'password' => Hash::make('cliente123'),
                'role' => 'cliente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Veterinario',
                'email' => 'veterinario@vet.com',
                'password' => Hash::make('vet123'),
                'role' => 'veterinario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Empleado',
                'email' => 'empleado@empleado.com',
                'password' => Hash::make('empleado123'),
                'role' => 'empleado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

