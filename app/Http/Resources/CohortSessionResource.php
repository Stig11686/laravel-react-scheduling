<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CohortSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'name' => $this->session->name,
            'trainer' => $this->trainer ? $this->trainer->user->name : null,
            'trainer_notes' => $this->session->trainer_notes,
            'slides' => $this->session->slides,
            'session_id' => $this->session->id,
            'cohort_id' => $this->cohort_id,
            'cohort_name' => $this->cohort->name,
            'course_name' => $this->cohort->course->name,
            'zoom_room' => $this->zoom_room ? $this->zoom_room->link : null,
            'zoom_room_id' => $this->zoom_room ? $this->zoom_room->id : null,
            'trainer_id' => $this->trainer ? $this->trainer->id : null
        ];
    }
}
