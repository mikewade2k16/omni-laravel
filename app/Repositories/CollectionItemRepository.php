<?php

namespace App\Repositories;

use App\Models\CollectionItem;

class CollectionItemRepository
{
    public function list()
    {
        return CollectionItem::all();
    }

    public function store(array $data)
    {
        return CollectionItem::create($data);
    }

    public function find($id)
    {
        return CollectionItem::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $item = CollectionItem::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function delete($id)
    {
        $item = CollectionItem::findOrFail($id);
        $item->delete();
    }
}
