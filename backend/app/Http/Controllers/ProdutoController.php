<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        return Produto::with('usuario')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string',
            'preco'     => 'required|numeric',
            'descricao' => 'nullable|string',
        ]);

        $produto = Produto::create([
            'nome'  => $request->nome,
            'preco' => $request->preco,
            'descricao' => $request->descricao,
            'usuario_id' => $request->user()->id,
        ]);

        return response()->json($produto, 201);
    }

    public function show(string $id)
    {
        return Produto::with('usuario')->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $produto = Produto::findOrFail($id);
        
        $produto->update($request->only('nome', 'preco', 'descricao'));

        return response()->json($produto);
    }

    public function destroy(string $id)
    {
        Produto::destroy($id);

        return response()->json(['message' => 'Produto deletado com sucesso.']);
    }
}
