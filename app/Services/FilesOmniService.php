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

    public function allFiles()
    {
        return $this->repository->all();
    }

    public function getFile($id)
    {
        return $this->repository->find($id);
    }

    public function createFile(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateFile($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteFile($id)
    {
        return $this->repository->delete($id);
    }
}
