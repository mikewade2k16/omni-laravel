<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Column\StoreColumnRequest;
use App\Http\Requests\Column\UpdateColumnRequest;
use App\Http\Resources\ColumnResource;
use App\Services\ColumnService;
use Illuminate\Http\JsonResponse;

class ColumnController extends Controller
{
    protected $service;

    public function __construct(ColumnService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $columns = $this->service->list();
        return ColumnResource::collection($columns);
    }

    public function show($id)
    {
        $column = $this->service->find($id);
        return new ColumnResource($column);
    }

    public function store(StoreColumnRequest $request): JsonResponse
    {
        try {
            $column = $this->service->store($request->validated());
            return response()->json(new ColumnResource($column), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar Coluna',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateColumnRequest $request, $id): JsonResponse
    {
        try {
            $column = $this->service->update($id, $request->validated());
            return response()->json(new ColumnResource($column), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar Coluna',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Coluna deletada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar Coluna',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}