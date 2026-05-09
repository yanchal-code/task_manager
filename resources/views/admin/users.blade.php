@extends('layouts.app')

@section('content')

<h3 class="mb-4">Users List</h3>

<table class="table table-bordered table-hover mt-3">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Tasks Count</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td><span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'secondary' }}">{{ $user->role }}</span></td>
            <td>{{ $user->tasks_count }}</td>
            <td>
                <a href="{{ route('admin.user.tasks', $user->id) }}" class="btn btn-sm btn-primary">View Tasks</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection