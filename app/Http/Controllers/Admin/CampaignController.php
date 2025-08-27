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

    // Criar uma nova campanha
    public function store(StoreCampaignRequest $request)
    {
        $campaign = $this->service->store($request->validated());
        return new CampaignResource($campaign);
    }

    // Visualizar uma campanha específica
    public function show($id)
    {
        $campaign = $this->service->find($id);
        return new CampaignResource($campaign);
    }

    // Atualizar uma campanha
    public function update(UpdateCampaignRequest $request, $id)
    {
        $campaign = $this->service->update($id, $request->validated());
        return new CampaignResource($campaign);
    }

    // Deletar uma campanha
    public function delete($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Campanha deletada com sucesso.']);
    }
}
