<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role'     => 'admin',
        ]);

        // 5 Regular Users
        $userNames = ['Alice Johnson', 'Bob Smith', 'Carol White', 'David Brown', 'Eva Davis'];
        $users = [];
        foreach ($userNames as $i => $name) {
            $users[] = User::create([
                'name'     => $name,
                'email'    => 'user' . ($i + 1) . '@gmail.com',
                'password' => Hash::make('123456'),
                'role'     => 'user',
            ]);
        }

        // 3 Categories
        $catNames = ['Work', 'Personal', 'Urgent'];
        $categories = [];
        foreach ($catNames as $name) {
            $categories[] = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        // 20 Tasks with varied statuses and priorities
        $statuses   = ['pending', 'in_progress', 'completed'];
        $priorities = ['low', 'medium', 'high'];

        $taskTitles = [
            'Design database schema',
            'Write API documentation',
            'Fix login bug',
            'Code review for PR #12',
            'Set up CI/CD pipeline',
            'Update user profile page',
            'Add email notifications',
            'Refactor task service',
            'Write unit tests',
            'Deploy to staging',
            'Fix mobile layout issues',
            'Integrate payment gateway',
            'Performance optimization',
            'Add CSV export feature',
            'Implement search functionality',
            'Update README file',
            'Create admin dashboard',
            'Add pagination to API',
            'Write seed data',
            'Security audit',
        ];

        foreach ($taskTitles as $i => $title) {
            $user = $users[$i % count($users)];

            $task = Task::create([
                'user_id'     => $user->id,
                'title'       => $title,
                'description' => 'Description for: ' . $title,
                'status'      => $statuses[$i % count($statuses)],
                'priority'    => $priorities[$i % count($priorities)],
                'due_date'    => now()->addDays(rand(1, 30))->toDateString(),
            ]);

            // Attach 1–2 random categories
            $task->categories()->sync(
                collect($categories)->random(rand(1, 2))->pluck('id')->toArray()
            );
        }
    }
}