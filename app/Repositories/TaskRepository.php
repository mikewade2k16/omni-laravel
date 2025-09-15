<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function list()
    {
        // ✅ MUDANÇA: Carregamos a coluna de cada tarefa.
        return Task::with('column')->get();
    }

    public function store(array $data)
    {
        return Task::create($data);
    }

    public function find($id)
    {
        // ✅ MUDANÇA: Carregamos a coluna da tarefa específica.
        return Task::with('column')->findOrFail($id);
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