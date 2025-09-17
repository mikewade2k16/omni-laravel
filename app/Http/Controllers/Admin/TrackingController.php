<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TrackingService;
use App\Http\Requests\Tracking\StoreTrackingRequest;

class TrackingController extends Controller
{
    protected $service;

    public function __construct(TrackingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->list(), 200);
    }

    public function show($id)
    {
        $tracking = $this->service->find($id);
        return response()->json($tracking, 200);
    }

    public function store(StoreTrackingRequest $request)
    {
        try {
            $tracking = $this->service->store($request->validated());
            return response()->json($tracking, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar Tracking',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(StoreTrackingRequest $request, $id)
    {
        try {
            $tracking = $this->service->update($id, $request->validated());
            return response()->json($tracking, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar Tracking',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Tracking deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar Tracking',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
