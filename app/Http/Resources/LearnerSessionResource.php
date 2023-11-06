<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LearnerSessionResource extends JsonResource
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
            'date' => $this->date,
            'name' => $this->session->name,
            'trainer' => $this->trainer ? $this->trainer->user->name : null,
            'zoom_room' => $this->zoom_room ? $this->zoom_room->link : null,
            'slides' => $this->session->slides,
        ];
    }
}
