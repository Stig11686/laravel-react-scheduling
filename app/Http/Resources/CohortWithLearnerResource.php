<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class CohortWithLearnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $learnerUsers = LearnerResource::collection(
            User::with(['learner', 'learner.cohort', 'learner.cohort.course', 'learner.cohort.course.course_type'])->whereIn('id', collect($this->learners)->pluck('user_id'))->get()
        );

        return [
            'id' => $this->id,
            'name' => $this->name,
            'learners' => $learnerUsers,
            'allAttendance' => $this->allAttendance,
        ];
    }
}
