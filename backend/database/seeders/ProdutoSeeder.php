<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        Produto::create([
            'nome' => 'Mouse Gamer',
            'preco' => 150.99,
            'descricao' => 'Mouse com 7 botões programáveis',
            'usuario_id' => 1
        ]);

        Produto::create([
            'nome' => 'Teclado Mecânico',
            'preco' => 300.00,
            'descricao' => 'Teclado com switch brown',
            'usuario_id' => 1
        ]);

        Produto::create([
            'nome' => 'Monitor 27 Polegadas',
            'preco' => 899.90,
            'descricao' => 'Monitor Full HD 144Hz',
            'usuario_id' => 2
        ]);

        Produto::create([
            'nome' => 'Placa de vídeo RTX 5070 TI',
            'preco' => 6699.90,
            'descricao' => 'Placa De Video GeForce RTX 5070 Ti Gaming Pro, 16GB, GDDR7, 256-bit',
            'usuario_id' => 2
        ]);

        Produto::create([
            'nome' => 'Headset Astro A50"',
            'preco' => 1999.90,
            'descricao' => 'Headset Gamer Logitech Astro A50 + Base Station',
            'usuario_id' => 3
        ]);
    }
}
