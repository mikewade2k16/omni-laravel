<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShortLink\StoreShortLinkRequest;
use App\Http\Requests\ShortLink\UpdateShortLinkRequest;
use App\Http\Resources\ShortLinkResource;
use App\Services\ShortLinkService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreShortLinkRequest",
 * required={"target_url"},
 * @OA\Property(property="target_url", type="string", format="url", example="https://minha-url-muito-longa-para-uma-campanha.com/landing-page"),
 * @OA\Property(property="short_url", type="string", format="url", description="A URL encurtada completa, pronta para ser compartilhada", example="https://meu.site/aB1cD2eF"),
 * @OA\Property(property="slug", type="string", example="promo-natal", description="Opcional. Se não enviado, um slug aleatório será gerado."),
 * @OA\Property(property="client_id", type="integer", example=1, nullable=true)
 * )
 *
 * @OA\Schema(
 * schema="UpdateShortLinkRequest",
 * @OA\Property(property="target_url", type="string", format="url", example="https://novo-url-muito-longa-para-uma-campanha.com/landing-page"),
 * @OA\Property(property="short_url", type="string", format="url", description="A URL encurtada completa, pronta para ser compartilhada", example="https://campanha.site/aB1cD2eF"),
 * @OA\Property(property="slug", type="string", example="promo-ano-novo", description="Opcional. Se não enviado, um slug aleatório será gerado."),
 * @OA\Property(property="client_id", type="integer", example=1, nullable=true)
 * ) 
 */
class ShortLinkController extends Controller
{
    protected $service;

    public function __construct(ShortLinkService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/short-links",
     * summary="Lista todos os links curtos",
     * tags={"Short Links"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ShortLink")))
     * )
     */
    public function index()
    {
        $shortLinks = $this->service->list();
        return ShortLinkResource::collection($shortLinks);
    }

    /**
     * @OA\Get(
     * path="/api/admin/short-links/{id}",
     * summary="Busca um link curto pelo ID",
     * tags={"Short Links"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/ShortLink")),
     * @OA\Response(response=404, description="Link curto não encontrado")
     * )
     */
    public function show($id)
    {
        $shortLink = $this->service->find($id);
        return new ShortLinkResource($shortLink);
    }

    /**
     * @OA\Post(
     * path="/api/admin/short-links",
     * summary="Cria um novo link curto",
     * tags={"Short Links"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreShortLinkRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/ShortLink")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreShortLinkRequest $request): JsonResponse
    {
        try {
            $shortLink = $this->service->store($request->validated());
            return response()->json(new ShortLinkResource($shortLink), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar ShortLink', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/short-links/{id}",
     * summary="Atualiza um link curto",
     * tags={"Short Links"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateShortLinkRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/ShortLink")),
     * @OA\Response(response=404, description="Link curto não encontrado")
     * )
     */
    public function update(UpdateShortLinkRequest $request, $id): JsonResponse
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

    /**
     * @OA\Delete(
     * path="/api/admin/short-links/{id}",
     * summary="Deleta um link curto",
     * tags={"Short Links"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Link curto não encontrado")
     * )
     */
    public function destroy($id): JsonResponse
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