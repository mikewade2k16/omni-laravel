<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Qrcode\StoreQrcodeRequest;
use App\Http\Requests\Qrcode\UpdateQrcodeRequest;
use App\Http\Resources\QrcodeResource;
use App\Services\QrcodeService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreQrcodeRequest",
 * required={"target_url"},
 * @OA\Property(property="target_url", type="string", format="url", example="https://seusite.com/pagina-de-destino"),
 * @OA\Property(property="slug", type="string", example="promo-verao-25", description="Opcional. Se não enviado, um slug único será gerado"),
 * @OA\Property(property="client_id", type="integer", example=1, nullable=true),
 * @OA\Property(property="is_active", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 * schema="UpdateQrcodeRequest",
 * @OA\Property(property="target_url", type="string", format="url", example="https://seusite.com/nova-pagina"),
 * @OA\Property(property="is_active", type="boolean", example=false)
 * )
 */
class QrcodeController extends Controller
{
    protected $service;

    public function __construct(QrcodeService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/qrcodes",
     * summary="Lista todos os QR Codes",
     * tags={"QR Codes"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Qrcode")))
     * )
     */
    public function index()
    {
        $qrcodes = $this->service->list();
        return QrcodeResource::collection($qrcodes);
    }

    /**
     * @OA\Get(
     * path="/api/admin/qrcodes/{id}",
     * summary="Busca um QR Code pelo ID",
     * tags={"QR Codes"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/Qrcode")),
     * @OA\Response(response=404, description="QR Code não encontrado")
     * )
     */
    public function show($id)
    {
        $qrcode = $this->service->find($id);

        if (!$qrcode) {
            return response()->json(['message' => 'QR Code não encontrado'], Response::HTTP_NOT_FOUND);
        }

        return new QrcodeResource($qrcode);
    }

    /**
     * @OA\Post(
     * path="/api/admin/qrcodes",
     * summary="Cria um novo QR Code",
     * tags={"QR Codes"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreQrcodeRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/Qrcode")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreQrcodeRequest $request): JsonResponse
    {
        try {
            $qrcode = $this->service->store($request->validated());
            return response()->json(new QrcodeResource($qrcode), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar QR Code',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/qrcodes/{id}",
     * summary="Atualiza um QR Code",
     * tags={"QR Codes"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateQrcodeRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/Qrcode")),
     * @OA\Response(response=404, description="QR Code não encontrado")
     * )
     */
    public function update(UpdateQrcodeRequest $request, $id): JsonResponse
    {
        try {
            $qrcode = $this->service->update($id, $request->validated());
            if (!$qrcode) {
                return response()->json(['message' => 'QR Code não encontrado'], Response::HTTP_NOT_FOUND);
            }
            return response()->json(new QrcodeResource($qrcode), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar QR Code',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/qrcodes/{id}",
     * summary="Deleta um QR Code",
     * tags={"QR Codes"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="QR Code não encontrado")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->service->delete($id);

            if (!$deleted) {
                return response()->json(['message' => 'QR Code não encontrado'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['message' => 'QR Code deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar QR Code',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}