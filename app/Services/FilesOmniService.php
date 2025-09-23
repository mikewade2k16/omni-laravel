<?php

namespace App\Services;

use App\Repositories\FilesOmniRepository;

class FilesOmniService
{
    protected $repository;

    public function __construct(FilesOmniRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list() 
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data) 
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id) 
    {
        return $this->repository->delete($id);
    }
}