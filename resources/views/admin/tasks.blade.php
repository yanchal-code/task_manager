@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Tasks Management</h3>
    <a href="{{ route('admin.tasks.export') }}" class="btn btn-success">⬇ Export CSV</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Filter Form --}}
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Status --</option>
            <option value="pending"     {{ request('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed"   {{ request('status') == 'completed'   ? 'selected' : '' }}>Completed</option>
        </select>
    </div>

    <div class="col-md-3">
        <select name="priority" class="form-select">
            <option value="">-- Priority --</option>
            <option value="low"    {{ request('priority') == 'low'    ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high"   {{ request('priority') == 'high'   ? 'selected' : '' }}>High</option>
        </select>
    </div>

    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search by title..." value="{{ request('search') }}">
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Title</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Due Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->user->name }}</td>
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
            <td>{{ $task->due_date ?? '—' }}</td>
            <td>
                <form method="POST" action="{{ route('admin.tasks.delete', $task->id) }}"
                      onsubmit="return confirm('Delete this task?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Pagination --}}
{{ $tasks->appends(request()->query())->links() }}

@endsection