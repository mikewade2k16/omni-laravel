<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionItem\StoreCollectionItemRequest;
use App\Http\Requests\CollectionItem\UpdateCollectionItemRequest;
use App\Http\Resources\CollectionItemResource;
use App\Models\CollectionItem;

class CollectionItemController extends Controller
{
    public function index()
    {
        return CollectionItemResource::collection(CollectionItem::all());
    }

    public function show($id)
    {
        $item = CollectionItem::findOrFail($id);
        return new CollectionItemResource($item);
    }

    public function store(StoreCollectionItemRequest $request)
    {
        $item = CollectionItem::create($request->validated());
        return new CollectionItemResource($item);
    }

    public function update(UpdateCollectionItemRequest $request, $id)
    {
        $item = CollectionItem::findOrFail($id);
        $item->update($request->validated());
        return new CollectionItemResource($item);
    }

    public function destroy($id)
    {
        $item = CollectionItem::findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Item deletado com sucesso.']);
    }
}
