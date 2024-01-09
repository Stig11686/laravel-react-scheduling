<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Http\Resources\LearnerResource;

class CohortAttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'learners' => LearnerResource::collection($this->learners),
            'attendance' => $this->formattedAttendance()
        ];
    }

    private function formattedAttendance()
    {
        $attendanceData = [];

        foreach ($this->cohortSession as $session) {
            $sessionName = $session->session->name;
            $sessionDate = $session->session->date;

            foreach ($this->learners as $learner) {
                $learnerName = $learner->user->name;

                $status = $this->attendance
                    ->where('learner_id', $learner->id)
                    ->where('session_id', $session->session_id)
                    ->first()
                    ->status ?? '';

                $attendanceData[$learnerName][$sessionName] = $status;
            }
        }

        return $attendanceData;
    }
}
