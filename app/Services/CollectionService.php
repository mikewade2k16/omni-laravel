<?php

namespace App\Services;

use App\Repositories\CollectionRepository;

class CollectionService
{
    protected $repo;

    public function __construct(CollectionRepository $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->list();
    }

    public function store(array $data)
    {
        return $this->repo->store($data);
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
