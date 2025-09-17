<?php

namespace App\Repositories;

use App\Models\Collection;

class CollectionRepository
{
    public function list()
    {
        return Collection::all();
    }

    public function store(array $data)
    {
        return Collection::create($data);
    }

    public function find($id)
    {
        return Collection::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $collection = Collection::findOrFail($id);
        $collection->update($data);
        return $collection;
    }

    public function delete($id)
    {
        $collection = Collection::findOrFail($id);
        $collection->delete();
    }
}
