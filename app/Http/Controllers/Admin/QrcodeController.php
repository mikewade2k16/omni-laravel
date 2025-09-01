<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Qrcode\StoreQrcodeRequest;
use App\Http\Requests\Qrcode\UpdateQrcodeRequest;
use App\Http\Resources\QrcodeResource;
use App\Services\QrcodeService;
use Illuminate\Http\Response;

class QrcodeController extends Controller
{
    protected $service;

    public function __construct(QrcodeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $qrcodes = $this->service->getAll();
        return QrcodeResource::collection($qrcodes);
    }

    public function show($id)
    {
        $qrcode = $this->service->getById($id);

        if (!$qrcode) {
            return response()->json(['message' => 'QR Code não encontrado'], Response::HTTP_NOT_FOUND);
        }

        return new QrcodeResource($qrcode);
    }

    public function store(StoreQrcodeRequest $request)
    {
        try {
            $qrcode = $this->service->create($request->validated());
            return response()->json(new QrcodeResource($qrcode), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar QR Code',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateQrcodeRequest $request, $id)
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

    public function destroy($id)
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
