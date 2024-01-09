<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LearnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'end_date' => $this->learner->cohort->end_date,
            'outstanding_tasks' => 0,
            'learnerDetails' => $this->when($this->isApprenticeship(), function () {
                return [
                    'coach' => $this->learner->trainer->user->name,
                    'portfolio_uploaded' => 0,
                    'employer' => $this->learner->employer ? $this->learner->employer->name : null,
                    'manager' => $this->learner->manager ? $this->learner->manager->name : null,
                ];
            }),
        ];
    }

    private function isApprenticeship()
    {
        // Access course type based on the pre-loaded relationship
        return $this->learner->cohort->course->course_type->name === 'Apprenticeship';
    }
}

