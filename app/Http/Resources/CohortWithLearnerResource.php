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
            User::whereIn('id', collect($this->learners)->pluck('user_id'))->get()
        );

        return [
            'id' => $this->id,
            'name' => $this->name,
            'course' => $this->course->name,
            'learners' => $learnerUsers,
            'allAttendance' => $this->allAttendance,
        ];
    }
}
