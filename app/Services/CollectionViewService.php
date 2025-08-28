<?php

namespace App\Services;

use App\Repositories\CollectionViewRepository;
use App\Models\CollectionView;

class CollectionViewService
{
    protected $repository;

    public function __construct(CollectionViewRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getById($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(CollectionView $view, array $data)
    {
        return $this->repository->update($view, $data);
    }

    public function delete(CollectionView $view)
    {
        return $this->repository->delete($view);
    }
}
