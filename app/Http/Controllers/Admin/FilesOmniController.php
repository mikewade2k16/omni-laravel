<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FilesOmniService;
use App\Http\Requests\FilesOmni\StoreFilesOmniRequest;
use App\Http\Requests\FilesOmni\UpdateFilesOmniRequest;
use App\Http\Resources\FilesOmniResource;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreFilesOmniRequest",
 * type="object",
 * title="Store FilesOmni Request",
 * required={"task_id", "client_id", "uploaded_by", "file_path", "file_name", "file_type", "version"},
 * properties={
 * @OA\Property(property="task_id", type="integer", example=1),
 * @OA\Property(property="client_id", type="integer", example=1),
 * @OA\Property(property="uploaded_by", type="integer", example=1),
 * @OA\Property(property="file_path", type="string", example="uploads/clients/file123.pdf"),
 * @OA\Property(property="file_name", type="string", example="contrato.pdf"),
 * @OA\Property(property="file_type", type="string", example="application/pdf"),
 * @OA\Property(property="version", type="string", enum={"preview", "final", "for_color"}, example="final"),
 * @OA\Property(property="video_orientation", type="string", enum={"vertical", "horizontal"}, example="vertical"),
 * @OA\Property(property="cover_image", type="string", example="path/to/cover.jpg"),
 * @OA\Property(property="published", type="boolean", example=true)
 * }
 * )
 *
 * @OA\Schema(
 * schema="UpdateFilesOmniRequest",
 * @OA\Property(property="file_name", type="string", example="contrato_assinado.pdf"),
 * @OA\Property(property="published", type="boolean", example=false)
 * )
 */
class FilesOmniController extends Controller
{
    protected $service;

    public function __construct(FilesOmniService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/files-omnis",
     * summary="Lista todos os arquivos",
     * tags={"Files Omni"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/FilesOmni")))
     * )
     */
    public function index()
    {
        return FilesOmniResource::collection($this->service->list());
    }

    /**
     * @OA\Get(
     * path="/api/admin/files-omnis/{id}",
     * summary="Busca um arquivo pelo ID",
     * tags={"Files Omni"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/FilesOmni")),
     * @OA\Response(response=404, description="Arquivo não encontrado")
     * )
     */
    public function show($id)
    {
        $file = $this->service->find($id);
        return new FilesOmniResource($file);
    }

    /**
     * @OA\Post(
     * path="/api/admin/files-omnis",
     * summary="Cria um novo registro de arquivo",
     * tags={"Files Omni"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreFilesOmniRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/FilesOmni")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreFilesOmniRequest $request): JsonResponse
    {
        try {
            $file = $this->service->store($request->validated());
            return response()->json(new FilesOmniResource($file), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar arquivo',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/files-omnis/{id}",
     * summary="Atualiza um registro de arquivo",
     * tags={"Files Omni"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateFilesOmniRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/FilesOmni")),
     * @OA\Response(response=404, description="Arquivo não encontrado")
     * )
     */
    public function update(UpdateFilesOmniRequest $request, $id): JsonResponse
    {
        try {
            $file = $this->service->update($id, $request->validated());
            return response()->json(new FilesOmniResource($file), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar arquivo',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/files-omnis/{id}",
     * summary="Deleta um registro de arquivo",
     * tags={"Files Omni"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Arquivo não encontrado")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Arquivo deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar arquivo',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}