<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct()
    {
        // TESTE DECISIVO: VAMOS VER SE O LARAVEL CONSEGUE CRIAR O CONTROLLER
        Log::info('--- O AuthController foi instanciado com sucesso ---');

        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        // Ponto de Rastreio 1: Chegamos aqui?
        Log::info('--- REQUISIÇÃO DE REGISTRO RECEBIDA ---');
        Log::info('Dados recebidos:', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'nick' => 'required|string|between:2,50|unique:users',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            // Se a validação falhar, vamos registrar o erro antes de retornar.
            Log::error('Validação falhou para registro de usuário.', $validator->errors()->toArray());
            return response()->json($validator->errors()->toJson(), 400);
        }

        // Ponto de Rastreio 2: A validação passou?
        Log::info('Validação passou. Tentando criar o usuário no banco de dados...');

        try {
            $user = User::create([
                'name' => $request->name,
                'nick' => $request->nick,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => 'client',
                'status' => 'active',
            ]);

            // Ponto de Rastreio 3: O usuário foi criado?
            Log::info('USUÁRIO CRIADO COM SUCESSO!', ['user_id' => $user->id, 'email' => $user->email]);

            return response()->json([
                'message' => 'Usuário registrado com sucesso!',
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            // Ponto de Rastreio 4: Se algo der errado no 'create', vamos pegar o erro!
            Log::error('!!! ERRO FATAL AO CRIAR USUÁRIO !!!', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Ocorreu um erro interno no servidor.'], 500);
        }
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
}