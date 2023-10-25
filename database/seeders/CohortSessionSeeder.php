<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Str;
use App\Models\Cohort;
use App\Models\Session;
use App\Models\Trainer;
use App\Models\ZoomRoom;
use Carbon\Carbon;

class CohortSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cohorts = Cohort::all();
        $sessions = Session::all();
        $trainers = Trainer::all();
        $zoomRooms = ZoomRoom::all();

        $cohorts->each(function ($cohort) use ($sessions, $trainers, $zoomRooms) {
            $sessionsToAdd = $sessions->random(16);

            $sessionsToAdd->each(function ($session) use ($cohort, $trainers, $zoomRooms) {
                $trainer = $trainers->random();
                $zoomRoom = $zoomRooms->random();

                $start = Carbon::parse($cohort->start_date);
                $end = Carbon::parse($cohort->end_date);
                $date = $start->copy()->addDays(rand(0, $end->diffInDays($start)));


                $hasTrainer = rand(0, 9) < 7; // 70% chance of having a trainer
                $hasZoomRoom = rand(0, 9) < 7; // 70% chance of having a zoom room

                if (!$hasTrainer) {
                    $trainer = null;
                }

                if (!$hasZoomRoom) {
                    $zoomRoom = null;
                }

                DB::table('cohort_session')->insertOrIgnore([
                    'cohort_id' => $cohort->id,
                    'session_id' => $session->id,
                    'date' => $date,
                    'trainer_id' => $trainer ? $trainer->id : null,
                    'zoom_room_id' => $zoomRoom ? $zoomRoom->id : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        });
    }
}
