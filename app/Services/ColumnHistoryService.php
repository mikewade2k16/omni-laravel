<?php

namespace App\Services;

use App\Repositories\ColumnHistoryRepository;

class ColumnHistoryService
{
    protected $repository;

    public function __construct(ColumnHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
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