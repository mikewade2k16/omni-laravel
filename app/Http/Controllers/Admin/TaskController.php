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

    public function store(StoreTaskRequest $request)
    {
        Log::info('Storing Task:');
        $task = $this->service->store($request->validated());
        return new TaskResource($task);
    }

    public function show($id)
    {
        $task = $this->service->find($id);
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->service->update($id, $request->validated());
        return new TaskResource($task);
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Tarefa deletada com sucesso.']);
    }
}
