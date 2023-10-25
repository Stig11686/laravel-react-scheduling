<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ZoomRoom;
use App\Models\Trainer;

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
            'name' => $this->session->name,
            'date' => $this->date,
            'slides' => $this->session->slides,
            'trainer_notes' => $this->session->trainer_notes,
            'zoom_room' => $this->zoom_room ? $this->zoom_room->link : null,
            'trainer' => $this->trainer ? $this->trainer->user->name : null
        ];
    }
}
