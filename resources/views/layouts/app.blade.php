<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel — Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">Task Manager</span>

    <div class="d-flex gap-2">
        <a href="/admin/dashboard" class="btn btn-light btn-sm">Dashboard</a>
        <a href="/admin/users"     class="btn btn-light btn-sm">Users</a>
        <a href="/admin/tasks"     class="btn btn-light btn-sm">Tasks</a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>