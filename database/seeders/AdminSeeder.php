<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    User::create([
        'name' => 'Administrador',
        'email' => 'admin@miempresa.com',
        'password' => Hash::make('12345678'),  // Asegúrate de poner una contraseña segura
        'role' => 'administrador',
    ]);
}
}