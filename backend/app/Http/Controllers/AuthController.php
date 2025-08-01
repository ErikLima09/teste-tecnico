<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function cadastrar(Request $request) {
        $request->validate([
            'nome'      => 'required|string',
            'cpf'       => 'required|numeric',
            'email'     => 'required|email|unique:usuarios,email',
            'password'  => 'required|string|min:8',
        ]);

        $usuario = Usuario::create([
            'nome'      => $request->nome,
            'cpf'       => $request->cpf,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        return response()->json(['usuario' => $usuario], 201);
    }

    public function login(Request $request) {
        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais estão incorretas.'],
            ]);
        }

        $token = $usuario->createToken('token')->plainTextToken;

        return response()->json([
            'usuario'   => $usuario,
            'token'     => $token,
        ]);
    }

    public function perfil(Request $request) {
        return response()->json($request->user());
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Deslogado com sucesso.']);
    }  
}
