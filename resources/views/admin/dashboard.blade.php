@extends('layouts.app')

@section('content')

<h3 class="mb-4">Dashboard</h3>

<div class="row mt-2 g-3">
    <div class="col-md-4">
        <div class="card p-3 bg-primary text-white">
            <h5>Total Tasks</h5>
            <h2>{{ $totalTasks }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 bg-success text-white">
            <h5>Total Users</h5>
            <h2>{{ $totalUsers }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 bg-secondary text-white">
            <h5>Pending Tasks</h5>
            <h2>{{ $pending }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 bg-warning text-dark">
            <h5>In Progress</h5>
            <h2>{{ $in_progress }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 bg-info text-dark">
            <h5>Completed Tasks</h5>
            <h2>{{ $completed }}</h2>
        </div>
    </div>
</div>

@endsection