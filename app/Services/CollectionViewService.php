<?php

namespace App\Services;

use App\Repositories\CollectionViewRepository;

class CollectionViewService
{
    protected $repository;

    public function __construct(CollectionViewRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function find($id)
    {
        return $this->repository->findOrFail($id);
    }

    public function store(array $data)
    {
        $userId = auth()->id();
        $data['created_by'] = $userId;
        return $this->repository->store($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }


    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}