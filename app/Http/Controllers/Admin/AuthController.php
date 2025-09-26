<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\StoreUserRequest;

/**
 * @OA\Schema(
 * schema="LoginRequest",
 * type="object",
 * title="Login Request",
 * required={"email", "password"},
 * @OA\Property(property="email", type="string", format="email", example="admin@admin.com"),
 * @OA\Property(property="password", type="string", format="password", example="password")
 * )
 *
 * @OA\Schema(
 * schema="AuthResponse",
 * type="object",
 * title="Authentication Response",
 * properties={
 * @OA\Property(property="access_token", type="string", description="O token de acesso JWT"),
 * @OA\Property(property="token_type", type="string", example="bearer"),
 * @OA\Property(property="expires_in", type="integer", example=3600, description="Tempo de expiração do token em segundos"),
 * @OA\Property(property="user", ref="#/components/schemas/User")
 * }
 * )
 *
 * @OA\Schema(
 * schema="RegisterRequest",
 * type="object",
 * title="Register Request",
 * required={"name", "nick", "email", "password", "password_confirmation"},
 * @OA\Property(property="name", type="string", example="Edson Oliveira"),
 * @OA\Property(property="nick", type="string", example="edinho"),
 * @OA\Property(property="email", type="string", format="email", example="edson@example.com"),
 * @OA\Property(property="password", type="string", format="password", example="senha123"),
 * @OA\Property(property="password_confirmation", type="string", format="password", example="senha123")
 * )
 */
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * summary="Autentica um usuário e retorna um token",
     * tags={"Authentication"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Login bem-sucedido",
     * @OA\JsonContent(ref="#/components/schemas/AuthResponse")
     * ),
     * @OA\Response(response=401, description="Não autorizado (credenciais inválidas)")
     * )
     */
    public function login(Request $request): JsonResponse
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

    /**
     * @OA\Post(
     * path="/api/register",
     * summary="Registra um novo usuário (requer autenticação)",
     * tags={"Authentication"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/RegisterRequest")),
     * @OA\Response(response=201, description="Usuário registrado com sucesso", @OA\JsonContent(
     * @OA\Property(property="message", type="string"),
     * @OA\Property(property="user", ref="#/components/schemas/User")
     * )),
     * @OA\Response(response=400, description="Erro de validação")
     * )
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        try {
            // Os dados já são validados pelo StoreUserRequest
            $validatedData = $request->validated();

            $user = User::create([
                'name'      => $validatedData['name'],
                'email'     => $validatedData['email'],
                'nick'      => $validatedData['nick'],
                'password'  => Hash::make($validatedData['password']),
                'status'    => $validatedData['status'],    // ✅ DADO ADICIONADO
                'level'     => $validatedData['level'],     // ✅ DADO ADICIONADO
                'user_type' => $validatedData['user_type'], // ✅ DADO ADICIONADO
            ]);

            return response()->json([
                'message' => 'Usuário registrado com sucesso!',
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao registrar usuário', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/logout",
     * summary="Desconecta o usuário (invalida o token)",
     * tags={"Authentication"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Desconectado com sucesso")
     * )
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     * path="/api/refresh",
     * summary="Atualiza um token expirado",
     * tags={"Authentication"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Token atualizado", @OA\JsonContent(ref="#/components/schemas/AuthResponse"))
     * )
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * @OA\Get(
     * path="/api/me",
     * summary="Retorna os dados do usuário autenticado",
     * tags={"Authentication"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/User"))
     * )
     */
    public function me(): JsonResponse
    {
        return response()->json(auth('api')->user());
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
}