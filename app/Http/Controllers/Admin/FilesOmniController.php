<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FilesOmniService;
use App\Http\Requests\FilesOmni\StoreFilesOmniRequest;
use App\Http\Requests\FilesOmni\UpdateFilesOmniRequest;
use App\Http\Resources\FilesOmniResource;

class FilesOmniController extends Controller
{
    protected $service;

    public function __construct(FilesOmniService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return FilesOmniResource::collection($this->service->allFiles());
    }

    public function show($id)
    {
        $file = $this->service->getFile($id);
        return new FilesOmniResource($file);
    }

    public function store(StoreFilesOmniRequest $request)
    {
        try {
            $file = $this->service->createFile($request->validated());
            return response()->json($file, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar arquivo',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateFilesOmniRequest $request, $id)
    {
        try {
            $file = $this->service->updateFile($id, $request->validated());
            return response()->json($file, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar arquivo',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->destroyFile($id);
            return response()->json(['message' => 'Arquivo deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar arquivo',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
