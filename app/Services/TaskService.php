<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Models\Task;

class TaskService
{
    protected $repository;

    public function __construct(TaskRepository $repository)
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
        $data['user_id'] = $userId;
        
        $involvedUserIds = $data['involved_users'] ?? [];

        $task = $this->repository->store($data);

        if (!empty($involvedUserIds)) {
            $task->users()->sync($involvedUserIds);
        }

        return $task->load(['column', 'users']);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function update($id, array $data)
    {
        $involvedUserIds = $data['involved_users'] ?? null;
        
        $task = $this->repository->update($id, $data);

        if (!is_null($involvedUserIds)) {
            $task->users()->sync($involvedUserIds);
        }

        return $task->load(['column', 'users']);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}