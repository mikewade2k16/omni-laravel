<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use Illuminate\Support\Facades\Log;

class ClientService
{
    protected $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list() { return $this->repository->list(); }

    public function store(array $data)
    {
        $client = $this->repository->store($data);
        Log::info('Client criado:', (array) $client);
        return $client;
    }

    public function find($id) 
    { 
        return $this->repository->find($id); 
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
