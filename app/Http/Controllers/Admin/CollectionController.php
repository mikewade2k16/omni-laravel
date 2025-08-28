<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CollectionService;
use App\Http\Requests\Collection\StoreCollectionRequest;
use App\Http\Requests\Collection\UpdateCollectionRequest;

class CollectionController extends Controller
{
    protected $service;

    public function __construct(CollectionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->list();
    }

    public function store(StoreCollectionRequest $request)
    {
        return $this->service->store($request->validated());
    }

    public function show($id)
    {
        return $this->service->find($id);
    }

    public function update(UpdateCollectionRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function delete($id)
    {
        return $this->service->delete($id);
    }
}
