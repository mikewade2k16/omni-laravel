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
        $qrcode = $this->service->create($request->validated());
        return new QrcodeResource($qrcode);
    }

    public function update(UpdateQrcodeRequest $request, $id)
    {
        $qrcode = $this->service->update($id, $request->validated());

        if (!$qrcode) {
            return response()->json(['message' => 'QR Code não encontrado'], Response::HTTP_NOT_FOUND);
        }

        return new QrcodeResource($qrcode);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'QR Code não encontrado'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'QR Code deletado com sucesso']);
    }
}
