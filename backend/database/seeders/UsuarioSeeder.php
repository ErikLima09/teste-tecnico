<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nome' => 'Usuario 1',
            'cpf' => '11122233344',
            'email' => 'teste1@email.com',
            'password' => Hash::make('12345678'),
        ]);

        Usuario::create([
            'nome' => 'Usuario 2',
            'cpf' => '22233344455',
            'email' => 'teste2@email.com',
            'password' => Hash::make('12345678'),
        ]);

        Usuario::create([
            'nome' => 'Usuario 3',
            'cpf' => '33333333333',
            'email' => 'teste3@email.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
