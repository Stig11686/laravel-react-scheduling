<?php

namespace App\Http\Resources;

use App\Models\Session;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TaskCollection;

class SessionResource extends JsonResource
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
        'name' => $this->name,
        'trainer_notes' => $this->trainer_notes,
        'slides' => $this->slides,
        'review_status' => $this->review_status,
        'review_due' => $this->review_due,
        'tasks' => new TaskCollection( $this->tasks ),
        'array_selected_id' => $this->tasks->pluck('id') ? $this->tasks->pluck('id') : []
       ];
    }
}
