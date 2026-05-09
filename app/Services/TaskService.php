<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    /**
     * Get paginated tasks for the authenticated user with optional filters.
     */
    public function getFilteredTasks(array $filters, int $userId): LengthAwarePaginator
    {
        $query = Task::where('user_id', $userId)->with('categories');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['category'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['category']);
            });
        }

        return $query->paginate(10);
    }

    /**
     * Create a new task and attach categories.
     */
    public function createTask(array $data, int $userId): Task
    {
        $task = Task::create([
            'user_id'     => $userId,
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'priority'    => $data['priority'],
            'due_date'    => $data['due_date'] ?? null,
        ]);

        $task->categories()->sync($data['category_ids'] ?? []);

        return $task->load('categories');
    }

    /**
     * Update a task and optionally re-sync categories.
     */
    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);

        if (array_key_exists('category_ids', $data)) {
            $task->categories()->sync($data['category_ids'] ?? []);
        }

        return $task->load('categories');
    }

    /**
     * Soft-delete a task.
     */
    public function deleteTask(Task $task): void
    {
        $task->delete();
    }

    /**
     * Update only the status field of a task.
     */
    public function updateStatus(Task $task, string $status): Task
    {
        $task->update(['status' => $status]);

        return $task->load('categories');
    }

    /**
     * Check if the given user owns this task.
     */
    public function isOwner(Task $task, int $userId): bool
    {
        return $task->user_id === $userId;
    }
}
