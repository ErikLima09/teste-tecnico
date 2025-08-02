<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        return Usuario::with('produtos')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'cpf' => 'required|string',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8',
        ]);

        $usuario = Usuario::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($usuario, 201);
    }

    public function show($id)
    {
        return Usuario::with('produtos')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->update($request->only('nome', 'cpf', 'email', 'password'));

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        return response()->json($usuario);
    }

    public function destroy($id)
    {
        Usuario::destroy($id);

        return response()->json(['message' => 'Usuário deletado com sucesso']);
    }
}
