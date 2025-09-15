<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionView\StoreCollectionViewRequest;
use App\Http\Requests\CollectionView\UpdateCollectionViewRequest;
use App\Http\Resources\CollectionViewResource;
use App\Services\CollectionViewService;
use App\Models\CollectionView;


class CollectionViewController extends Controller
{
    protected $service;

    public function __construct(CollectionViewService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $views = $this->service->getAll();
        return CollectionViewResource::collection($views);
    }

    public function show($id)
    {
        $view = $this->service->getById($id);
        return new CollectionViewResource($view);
    }

    public function store(StoreCollectionViewRequest $request)
    {
        try {
            $view = $this->service->create($request->validated());
            return response()->json(new CollectionViewResource($view), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar CollectionView',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateCollectionViewRequest $request, $id)
    {
        try {
            $view = $this->service->update($id, $request->validated());
            return response()->json(new CollectionViewResource($view), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar CollectionView',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'CollectionView deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar CollectionView',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
