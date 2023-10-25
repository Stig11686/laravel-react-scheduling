<?php

namespace App\Http\Resources;

use App\Models\ZoomRoom;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoomRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $zoom_room = ZoomRoom::where('id', $this->resource)->pluck('link');

        return $zoom_room;
    }
}
