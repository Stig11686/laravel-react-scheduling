<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
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
        $learnerUsers = UserResource::collection(
            User::whereIn('id', collect($this->learners)->pluck('user_id'))->get()
        );

        return [
            'id' => $this->id,
            'name' => $this->name,
            'learners' => $learnerUsers// Assuming 'name' is the column in the users table you want to retrieve
        ];
    }
}
