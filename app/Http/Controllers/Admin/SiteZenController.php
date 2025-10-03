<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SiteZenService;
use App\Http\Requests\SiteZen\StoreSiteZenRequest;
use App\Http\Requests\SiteZen\UpdateSiteZenRequest;
use App\Http\Resources\SiteZenResource;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreSiteZenRequest",
 * required={"mes", "visitas", "compras", "novas_visitas", "taxa_conversao", "ticket_medio", "receita_total", "produtos_mais_vistos", "produtos_comprados", "funil_usuarios"},
 * @OA\Property(property="mes", type="string", maxLength=50, example="Janeiro"),
 * @OA\Property(property="visitas", type="integer", format="int32", example=1500),
 * @OA\Property(property="compras", type="integer", format="int32", example=50),
 * @OA\Property(property="novas_visitas", type="integer", format="int32", example=1200),
 * @OA\Property(property="taxa_conversao", type="number", format="float", example=3.33),
 * @OA\Property(property="ticket_medio", type="number", format="float", example=250.75),
 * @OA\Property(property="pa", type="number", format="float", example=1.5),
 * @OA\Property(property="receita_total", type="number", format="float", example=12537.50),
 * @OA\Property(property="produtos_mais_vistos", type="array", @OA\Items(type="object")),
 * @OA\Property(property="produtos_comprados", type="array", @OA\Items(type="object")),
 * @OA\Property(property="funil_usuarios", type="array", @OA\Items(type="object"))
 * )
 *
 * @OA\Schema(
 * schema="UpdateSiteZenRequest",
 * @OA\Property(property="mes", type="string", maxLength=50, example="Janeiro"),
 * @OA\Property(property="visitas", type="integer", format="int32", example=1500),
 * @OA\Property(property="compras", type="integer", format="int32", example=50),
 * @OA\Property(property="novas_visitas", type="integer", format="int32", example=1200),
 * @OA\Property(property="taxa_conversao", type="number", format="float", example=3.33),
 * @OA\Property(property="ticket_medio", type="number", format="float", example=250.75),
 * @OA\Property(property="pa", type="number", format="float", example=1.5),
 * @OA\Property(property="receita_total", type="number", format="float", example=12537.50),
 * @OA\Property(property="produtos_mais_vistos", type="array", @OA\Items(type="object")),
 * @OA\Property(property="produtos_comprados", type="array", @OA\Items(type="object")),
 * @OA\Property(property="funil_usuarios", type="array", @OA\Items(type="object"))
 * )
 */
class SiteZenController extends Controller
{
    protected $service;

    public function __construct(SiteZenService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/site-zen",
     * summary="Lista todos os registros de métricas do Site Zen",
     * tags={"Site Zen"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/SiteZen")))
     * )
     */
    public function index()
    {
        $siteZens = $this->service->list();
        return SiteZenResource::collection($siteZens);
    }

    /**
     * @OA\Get(
     * path="/api/admin/site-zen/{id}",
     * summary="Busca um registro de métrica pelo ID",
     * tags={"Site Zen"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/SiteZen")),
     * @OA\Response(response=404, description="Registro não encontrado")
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $siteZen = $this->service->find($id);

            if (!$siteZen) {
                return response()->json(['message' => 'SiteZen não encontrada'], 404);
            }
            return response()->json(new SiteZenResource($siteZen), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar SiteZen', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/admin/site-zen",
     * summary="Cria um novo registro de métrica",
     * tags={"Site Zen"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreSiteZenRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/SiteZen")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreSiteZenRequest $request): JsonResponse
    {
        try {
            $siteZen = $this->service->store($request->validated());
            return response()->json(new SiteZenResource($siteZen), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar SiteZen',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/site-zen/{id}",
     * summary="Atualiza um registro de métrica",
     * tags={"Site Zen"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateSiteZenRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/SiteZen")),
     * @OA\Response(response=404, description="Registro não encontrado")
     * )
     */
    public function update(UpdateSiteZenRequest $request, $id): JsonResponse
    {
        try {
            $siteZen = $this->service->update($id, $request->validated());
            return response()->json(new SiteZenResource($siteZen), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar SiteZen',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/site-zen/{id}",
     * summary="Deleta um registro de métrica",
     * tags={"Site Zen"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Registro não encontrado")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'SiteZen deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar SiteZen',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}