<?php

namespace App\Repositories;

use App\Models\CollectionView;

class CollectionViewRepository
{
    public function all()
    {
        return CollectionView::all();
    }

    public function find($id)
    {
        return CollectionView::findOrFail($id);
    }

    public function create(array $data)
    {
        return CollectionView::create($data);
    }

    public function update(CollectionView $view, array $data)
    {
        $view->update($data);
        return $view;
    }

    public function delete(CollectionView $view)
    {
        return $view->delete();
    }
}
