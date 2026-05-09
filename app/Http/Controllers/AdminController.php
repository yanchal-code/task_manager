<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalTasks' => Task::count(),
            'totalUsers' => User::count(),
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed' => Task::where('status', 'completed')->count(),
        ]);
    }

    public function users()
    {
        return view('admin.users', ['users' => User::where('role', 'user')->withCount('tasks')->get(),]);
    }

    public function userTasks(User $user)
    {
        return view('admin.user_tasks', [
            'user' => $user,
            'tasks' => $user->tasks()->with('categories')->paginate(10),
        ]);
    }

    public function tasks(Request $request)
    {
        $query = Task::with('user');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return view('admin.tasks', [
            'tasks' => $query->paginate(10),
        ]);
    }

    public function softDelete(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

    public function export()
    {
        $tasks = Task::with('user')->get();

        $filename = 'tasks_export_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($tasks) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Title', 'User', 'Status', 'Priority', 'Due Date', 'Created At']);
            foreach ($tasks as $task) {
                fputcsv($file, [
                    $task->id,
                    $task->title,
                    $task->user->name ?? 'N/A',
                    $task->status,
                    $task->priority,
                    $task->due_date,
                    $task->created_at->toDateTimeString(),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

