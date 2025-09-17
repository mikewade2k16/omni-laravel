<?php

namespace App\Services;

use App\Repositories\CampaignRepository;
use Illuminate\Support\Facades\Log;

class CampaignService
{
    protected $repository;

    public function __construct(CampaignRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function store(array $data)
    {
        $campaign = $this->repository->store($data);
        Log::info('Campaign criada:', (array) $campaign);
        return $campaign;
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
