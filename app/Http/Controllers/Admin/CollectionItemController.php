<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CollectionItemService;
use App\Http\Requests\CollectionItem\StoreCollectionItemRequest;
use App\Http\Requests\CollectionItem\UpdateCollectionItemRequest;

class CollectionItemController extends Controller
{
    protected $service;

    public function __construct(CollectionItemService $service)
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

    public function store(StoreCollectionItemRequest $request)
    {
        try {
            $item = $this->service->store($request->validated());
            return response()->json($item, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar CollectionItem',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateCollectionItemRequest $request, $id)
    {
        try {
            $item = $this->service->update($id, $request->validated());
            return response()->json($item, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar CollectionItem',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'Item deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar CollectionItem',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
