@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="/admin/users" class="btn btn-outline-secondary btn-sm">← Back to Users</a>
    <h3 class="mb-0">Tasks for: {{ $user->name }}</h3>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Categories</th>
            <th>Due Date</th>
        </tr>
    </thead>

    <tbody>
        @forelse($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>
                <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'warning text-dark' : 'secondary') }}">
                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                </span>
            </td>
            <td>
                <span class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning text-dark' : 'success') }}">
                    {{ ucfirst($task->priority) }}
                </span>
            </td>
            <td>{{ $task->categories->pluck('name')->join(', ') ?: '—' }}</td>
            <td>{{ $task->due_date ?? '—' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted">No tasks found for this user.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $tasks->links() }}

@endsection
