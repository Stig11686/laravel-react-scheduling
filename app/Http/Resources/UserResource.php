<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $roles = $this->whenLoaded('roles') ? $this->roles->pluck('name') : [];
        $permissions = $this->whenLoaded('permissions') ? $this->permissions->pluck('name') : [];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $roles,
            'permissions' => $permissions

        ];
    }
}
