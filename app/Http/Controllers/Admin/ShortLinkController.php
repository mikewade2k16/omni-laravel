<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShortLink\StoreShortLinkRequest;
use App\Http\Requests\ShortLink\UpdateShortLinkRequest;
use App\Http\Resources\ShortLinkResource;
use App\Services\ShortLinkService;
use Illuminate\Http\Request;

class ShortLinkController extends Controller
{
    protected $service;

    public function __construct(ShortLinkService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $shortLinks = $this->service->list();
        return ShortLinkResource::collection($shortLinks);
    }

    public function show($id)
    {
        $shortLink = $this->service->get($id);
        return new ShortLinkResource($shortLink);
    }

    public function store(StoreShortLinkRequest $request)
    {
        try {
            $shortLink = $this->service->create($request->validated());
            return response()->json(new ShortLinkResource($shortLink), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar ShortLink',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateShortLinkRequest $request, $id)
    {
        try {
            $shortLink = $this->service->update($id, $request->validated());
            return response()->json(new ShortLinkResource($shortLink), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar ShortLink',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'ShortLink deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar ShortLink',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
