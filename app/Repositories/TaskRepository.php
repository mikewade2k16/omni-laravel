<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function list()
    {
        return Task::with(['column', 'users'])->get();
    }

    public function store(array $data)
    {
        return Task::create($data);
    }

    public function find($id)
    {
        return Task::with(['column', 'users'])->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $task = Task::findOrFail($id);
        $task->update($data);
        return $task;
    }

    public function delete($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }
}