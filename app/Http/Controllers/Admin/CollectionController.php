<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CollectionService;
use App\Http\Requests\Collection\StoreCollectionRequest;
use App\Http\Requests\Collection\UpdateCollectionRequest;

class CollectionController extends Controller
{
    protected $service;

    public function __construct(CollectionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->list();
    }

    public function show($id)
    {
        return $this->service->find($id);
    }

    public function store(StoreCollectionRequest $request)
    {
        try {
            $collection = $this->service->store($request->validated());
            return response()->json($collection, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar Collection',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateCollectionRequest $request, $id)
    {
        try {
            $collection = $this->service->update($id, $request->validated());
            return response()->json($collection, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar Collection',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'Collection deletada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar Collection',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
