<?php

namespace App\Services;

use App\Repositories\CollectionItemRepository;

class CollectionItemService
{
    protected $repository;

    public function __construct(CollectionItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function store(array $data)
    {
        $userId = auth()->id();

        $data['created_by'] = $userId;
        $data['updated_by'] = $userId;

        return $this->repository->store($data);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function update($id, array $data)
    {
        $userId = auth()->id();

        $data['updated_by'] = $userId;

        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}