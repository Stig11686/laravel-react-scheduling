<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class CohortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $learnerUsers = LearnerResource::collection(
            User::whereIn('id', collect($this->learners)->pluck('user_id'))->get()
        );

        return [
            'id' => $this->id,
            'name' => $this->name,
            'course' => $this->course->name,
            'course_id' => $this->course->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'places' => $this->places,
            'learners' => $learnerUsers
        ];
    }
}
