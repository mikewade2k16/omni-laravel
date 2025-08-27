<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    protected $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return ClientResource::collection($this->service->list());
    }

    public function store(StoreClientRequest $request)
    {
        $client = $this->service->store($request->validated());
        return new ClientResource($client);
    }

    public function show($id)
    {
        $client = $this->service->find($id);
        return new ClientResource($client);
    }

    public function update(UpdateClientRequest $request, $id)
    {
        $client = $this->service->update($id, $request->validated());
        return new ClientResource($client);
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Cliente deletado com sucesso.']);
    }
}
