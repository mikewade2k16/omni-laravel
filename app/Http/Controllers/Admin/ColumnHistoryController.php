<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColumnHistory\StoreColumnHistoryRequest;
use App\Http\Requests\ColumnHistory\UpdateColumnHistoryRequest;
use App\Http\Resources\ColumnHistoryResource;
use App\Services\ColumnHistoryService;
use Illuminate\Http\JsonResponse;

class ColumnHistoryController extends Controller
{
    protected $service;

    public function __construct(ColumnHistoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $histories = $this->service->list();
        return ColumnHistoryResource::collection($histories);
    }

    public function show($id)
    {
        $history = $this->service->find($id);
        return new ColumnHistoryResource($history);
    }

    public function store(StoreColumnHistoryRequest $request): JsonResponse
    {
        try {
            $history = $this->service->store($request->validated());
            return response()->json(new ColumnHistoryResource($history), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar Histórico',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateColumnHistoryRequest $request, $id): JsonResponse
    {
        try {
            $history = $this->service->update($id, $request->validated());
            return response()->json(new ColumnHistoryResource($history), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar Histórico',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'Histórico deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar Histórico',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}