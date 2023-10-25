<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Session;
use App\Models\Task;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $sessions = Session::all();
        $faker = Faker::create();

        foreach ($sessions as $session) {
            // Generate a fake task name
            $taskName = trim($faker->sentence(rand(4, 8)));
            $taskDescription = trim($faker->sentence(rand(4, 8)));

            // Create a task for each session
            $task = new Task();
            $task->name = $taskName;
            $task->description = $taskDescription;
            $task->save();
        }
    }
}
