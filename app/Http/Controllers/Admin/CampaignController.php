<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaign\StoreCampaignRequest;
use App\Http\Requests\Campaign\UpdateCampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Services\CampaignService;

class CampaignController extends Controller
{
    protected $service;

    public function __construct(CampaignService $service)
    {
        $this->service = $service;
    }

    // Listar todas as campanhas
    public function index()
    {
        return CampaignResource::collection($this->service->list());
    }

    // Visualizar uma campanha específica
    public function show($id)
    {
        $campaign = $this->service->find($id);
        return new CampaignResource($campaign);
    }

    // Criar uma nova campanha
    public function store(StoreCampaignRequest $request)
    {
        try {
            $campaign = $this->service->store($request->validated());
            return response()->json(new CampaignResource($campaign), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar campanha',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // Atualizar uma campanha
    public function update(UpdateCampaignRequest $request, $id)
    {
        try {
            $campaign = $this->service->update($id, $request->validated());
            return response()->json(new CampaignResource($campaign), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar campanha',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // Deletar uma campanha
    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'Campanha deletada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar campanha',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
