<?php

namespace App\Repositories;

use App\Models\CollectionView;

class CollectionViewRepository
{
    public function list()
    {
        return CollectionView::all();
    }

    public function findOrFail($id)
    {
        return CollectionView::findOrFail($id);
    }

    public function store(array $data)
    {
        return CollectionView::create($data);
    }

    public function update(int $id, array $data)
    {
        $view = $this->findOrFail($id);
        $view->update($data);
        return $view;
    }

    public function delete(int $id)
    {
        $view = $this->findOrFail($id);
        return $view->delete();
    }
}
