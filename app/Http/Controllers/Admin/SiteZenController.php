<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SiteZenService;
use App\Http\Requests\SiteZen\StoreSiteZenRequest;
use App\Http\Requests\SiteZen\UpdateSiteZenRequest;
use App\Http\Resources\SiteZenResource;
use Illuminate\Http\JsonResponse;

class SiteZenController extends Controller
{
    protected $service;

    public function __construct(SiteZenService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $siteZens = $this->service->getAll();
        return SiteZenResource::collection($siteZens);
    }

    public function show($id)
    {
        $siteZen = $this->service->getById($id);
        return new SiteZenResource($siteZen);
    }

    public function store(StoreSiteZenRequest $request): JsonResponse
    {
        try {
            $siteZen = $this->service->create($request->validated());
            return response()->json(new SiteZenResource($siteZen), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar SiteZen',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateSiteZenRequest $request, $id)
    {
        try {
            $siteZen = $this->service->update($id, $request->validated());
            return response()->json(new SiteZenResource($siteZen), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar SiteZen',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
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
