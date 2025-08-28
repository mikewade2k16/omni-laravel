<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionView\StoreCollectionViewRequest;
use App\Http\Requests\CollectionView\UpdateCollectionViewRequest;
use App\Http\Resources\CollectionViewResource;
use App\Services\CollectionViewService;
use App\Models\CollectionView;


class CollectionViewController extends Controller
{
    protected $service;

    public function __construct(CollectionViewService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $views = $this->service->getAll();
        return CollectionViewResource::collection($views);
    }

    public function show($id)
    {
        $view = $this->service->getById($id);
        return new CollectionViewResource($view);
    }

    public function store(StoreCollectionViewRequest $request)
    {
        $view = $this->service->create($request->validated());
        return new CollectionViewResource($view);
    }

    public function update(UpdateCollectionViewRequest $request, CollectionView $collectionView)
    {
        $view = $this->service->update($collectionView, $request->validated());
        return new CollectionViewResource($view);
    }

    public function destroy(CollectionView $collectionView)
    {
        $this->service->delete($collectionView);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
