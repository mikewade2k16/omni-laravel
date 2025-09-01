<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return TaskResource::collection($this->service->list());
    }

    public function show($id)
    {
        $task = $this->service->find($id);
        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request)
    {
        try {
            $task = $this->service->store($request->validated());
            return response()->json(new TaskResource($task), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar Tarefa',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        try {
            $task = $this->service->update($id, $request->validated());
            return response()->json(new TaskResource($task), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar Tarefa',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Tarefa deletada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar Tarefa',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
