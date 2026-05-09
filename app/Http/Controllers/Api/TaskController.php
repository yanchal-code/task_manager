<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService) {}

    public function index()
    {
        $tasks = $this->taskService->getFilteredTasks(
            request()->only(['status', 'priority', 'category']),
            auth()->id()
        );

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated(), auth()->id());

        return response()->json(new TaskResource($task), 201);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        if (!$this->taskService->isOwner($task, auth()->id())) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $task = $this->taskService->updateTask($task, $request->validated());

        return response()->json(new TaskResource($task), 200);
    }

    public function destroy(Task $task)
    {
        if (!$this->taskService->isOwner($task, auth()->id())) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $this->taskService->deleteTask($task);

        return response()->json(['message' => 'Task deleted'], 200);
    }

    public function status(UpdateTaskStatusRequest $request, Task $task)
    {
        if (!$this->taskService->isOwner($task, auth()->id())) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $task = $this->taskService->updateStatus($task, $request->validated()['status']);

        return response()->json(new TaskResource($task), 200);
    }
}
