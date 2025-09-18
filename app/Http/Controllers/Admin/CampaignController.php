<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaign\StoreCampaignRequest;
use App\Http\Requests\Campaign\UpdateCampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Services\CampaignService;
use Illuminate\Http\JsonResponse; // Importar JsonResponse

/**
 * @OA\Schema(
 * schema="StoreCampaignRequest",
 * required={"client_id", "name", "start_date", "end_date"},
 * @OA\Property(property="client_id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="Campanha de Verão"),
 * @OA\Property(property="description", type="string", example="Descrição da campanha de verão."),
 * @OA\Property(property="start_date", type="string", format="date", example="2025-01-30"),
 * @OA\Property(property="end_date", type="string", format="date", example="2025-02-28"),
 * @OA\Property(property="status", type="string", example="active"),
 * @OA\Property(property="channels", type="array", @OA\Items(type="string"), example={"facebook", "instagram"})
 * )
 *
 * @OA\Schema(
 * schema="UpdateCampaignRequest",
 * @OA\Property(property="name", type="string", example="Nova Campanha de Verão")
 * )
 */
class CampaignController extends Controller
{
    protected $service;

    public function __construct(CampaignService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/campaigns",
     * summary="Lista todas as campanhas",
     * tags={"Campaigns"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Campaign")))
     * )
     */
    public function index()
    {
        return CampaignResource::collection($this->service->list());
    }

    /**
     * @OA\Get(
     * path="/api/admin/campaigns/{id}",
     * summary="Busca uma campanha pelo ID",
     * tags={"Campaigns"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/Campaign")),
     * @OA\Response(response=404, description="Campanha não encontrada")
     * )
     */
    public function show($id)
    {
        $campaign = $this->service->find($id);
        return new CampaignResource($campaign);
    }

    /**
     * @OA\Post(
     * path="/api/admin/campaigns",
     * summary="Cria uma nova campanha",
     * tags={"Campaigns"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreCampaignRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/Campaign")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreCampaignRequest $request): JsonResponse
    {
        try {
            $campaign = $this->service->store($request->validated());
            return response()->json(new CampaignResource($campaign), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar campanha', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/campaigns/{id}",
     * summary="Atualiza uma campanha",
     * tags={"Campaigns"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateCampaignRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/Campaign")),
     * @OA\Response(response=404, description="Campanha não encontrada")
     * )
     */
    public function update(UpdateCampaignRequest $request, $id): JsonResponse
    {
        try {
            $campaign = $this->service->update($id, $request->validated());
            // Corrigindo o status code para 200 (OK) em vez de 201 (Created)
            return response()->json(new CampaignResource($campaign), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar campanha', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/campaigns/{id}",
     * summary="Deleta uma campanha",
     * tags={"Campaigns"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Campanha não encontrada")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Campanha deletada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar campanha', 'error' => $e->getMessage()], 500);
        }
    }
}