<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LearnerCourseResource;
use App\Models\User;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //Originally I loaded all the users with the course - however, I feel I don't need to do that
        //any more. I have left this code here in case I need to reintroduce it!

        //TODO - REMOVE THIS WHEN I KNOW I DON'T NEED IT
        // $learnerUsers = LearnerCourseResource::collection(
        //     User::whereIn('id', collect($this->learners)->pluck('user_id'))->get()
        // );

        return [
            'id' => $this->id,
            'name' => $this->name,
            'learners' => $this->learner_count
        ];
    }
}
