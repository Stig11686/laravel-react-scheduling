<?php

namespace App\Services;

use App\Models\User;
use App\Models\Cohort;
use App\Models\CohortSession;
use App\Http\Resources\LearnerScheduleCollection;
use App\Http\Resources\InstanceCollection;
use Spatie\Permission\Models\Role;

class ScheduleService
{
    public function getScheduleForUser($user)
    {
        if(!$user ){
            $user = User::find(1);
        }


        if ($user->hasRole(['super-admin', 'admin'])) {
            $cohorts = Cohort::with([
                'course',
                'cohortSession' => function($query) {
                    $query->with([
                        'trainer.user',
                        'zoom_room',
                        'session'
                    ]);
                },
            ])->paginate(15);

            return [
                'data' => new InstanceCollection($cohorts), 
                'pagination' => [
                'total' => $cohorts->total(),
                'per_page' => $cohorts->perPage(),
                'current_page' => $cohorts->currentPage(),
                'last_page' => $cohorts->lastPage(),
                'from' => $cohorts->firstItem(),
                'to' => $cohorts->lastItem()
                ]
                ];
        }

        if ($user->hasRole('trainer')) {
            $trainerId = $user->trainer->id;
            $cohortSessions = CohortSession::with(['cohort', 'trainer.user', 'cohort.course', 'zoom_room', 'session'])
                ->where('trainer_id', $trainerId)
                ->get()
                ->groupBy('cohort_id');

                return $cohortSessions->map(function ($cohortSession) {
                    return [
                        'cohort_id' => $cohortSession->cohort->id,
                        'cohort_name' => $cohortSession->cohort->name,
                        'course_name' => $cohortSession->cohort->course->name,
                        'sessions' => $cohortSession->map(function ($session) {
                            return [
                                'id' => $session->id,
                                'session_id' => $session->session_id,
                                'date' => $session->date,
                                'session_name' => $session->session->name,
                                'slides' => $session->session->slides,
                                'trainer_notes' => $session->session->trainer_notes,
                                // Add more session details as needed
                            ];
                        }),
                    ];
                })->values()->all();
            }

        if ($user->hasRole('learner')) {
            $learnerSchedule = Cohort::whereHas('learners', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['course', 'cohortSession.trainer.user', 'cohortSession.zoom_room', 'cohortSession.session'])->get();

            return new LearnerScheduleCollection($learnerSchedule);
        }

        return [];
    }
}
