<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Session;
use App\Models\Task;

class SessionTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sessions = Session::all();
        $tasks = Task::all();

        $sessions->each(function ($session) use ($tasks) {
            // Assign between 1 and 3 random tasks to each session
            $taskCount = rand(1, 3);

            // Shuffle tasks and take the first $taskCount tasks
            $selectedTasks = $tasks->shuffle()->take($taskCount);

            // Attach selected tasks to the session
            $session->tasks()->attach($selectedTasks);
        });
    }
}
