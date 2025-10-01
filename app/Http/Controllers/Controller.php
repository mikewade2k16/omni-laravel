<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 * version="1.0.0",
 * title="Omni - Documentação da API",
 * description="Documentação de todos os endpoints da API do sistema Omni."
 * )
 * @OA\SecurityScheme(
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * securityScheme="bearerAuth"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}