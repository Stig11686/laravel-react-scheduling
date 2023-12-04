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
            'coach' => $this->learner->trainer->user->name,
            'outstanding_tasks' => 0,
            'portfolio_uploaded' => 0,
            'employer' => $this->when($this->learner->employer, function () {
                return $this->learner->employer->name;
            }),
        ];
    }
}
