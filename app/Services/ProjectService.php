<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Support\Facades\Auth;

class ProjectService
{
    protected $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function store(array $data)
    {
        $members = $data['members'] ?? [];
        unset($data['members']);

        $data['user_id'] = Auth::id();

        $project = $this->repository->store($data);

        if (!empty($members)) {
            $project->members()->sync($members);
        }

        return $project->load(['creator', 'members']);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function update($id, array $data)
    {
        $members = $data['members'] ?? null;
        unset($data['members']);
        
        $project = $this->repository->update($id, $data);

        if (!is_null($members)) {
            $project->members()->sync($members);
        }

        return $project->load(['creator', 'members']);
    }

    public function delete($id)
    {
        $this->repository->delete($id);
    }
}