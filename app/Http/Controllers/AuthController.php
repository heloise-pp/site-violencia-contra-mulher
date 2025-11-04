<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * POST /api/login
     * Autentica o usuário e gera o token de acesso
     */
    public function login(Request $request)
    {
        // Validação
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenta Autenticar
        if (Auth::attempt($credentials)) {
            // Sucesso na autenticação
            $user = Auth::user();

            // Cria o Token de Acesso

            $token = $user->createToken('auth_token')->plainTextToken;

            // retorna o token para o cliente
            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        }

        // Falha na autenticação
        return response()->json([
            'message' => 'Credenciais inválidas. Verifique seu email e senha.'
        ], 401); // 401 = Unauthorized
    }

    /**
     * POST /api/logout
     * Revoga o token atual do usuário.
     */
    public function logout(Request $request)
    {
        // revoga o token atual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sessão encerrada com sucesso.'
        ], 200);
    }
}
