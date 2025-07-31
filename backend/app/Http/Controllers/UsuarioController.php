<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::with('produtos');

        if ($request->has('buscar')) {
            $query->where('nome', 'like', "%{$request->buscar}%")
                ->orWhere('email', 'like', "%{$request->buscar}%");
        }

        return response()->json($query->paginate(10));
    }
}
