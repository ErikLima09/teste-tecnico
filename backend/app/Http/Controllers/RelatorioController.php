<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function relatorio()
    {
        $relatorio = DB::select("
            Select
                u.id,
                u.nome,
                COUNT(p.id) as total_produtos, 
                COALESCE(AVG(p.preco), 0) as media_preco
            from usuarios u
            left join produtos p on p.usuario_id = u.id
            Group by u.id, u.nome
            Order by u.nome
        ");

        return response()->json($relatorio);
    }
}
