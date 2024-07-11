<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCompleteResource extends JsonResource
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
            'identifier' => $this->identifier,
            'username' => $this->username,
            'role' => $this->role,
            'bio' => $this->bio,
            'email' => $this->email,
            'phone' => $this->phone,
            'banner_picture' => $this->banner_picture,
            'profile_picture' => $this->profile_picture,
            'followers' => $this->followers_count,
            'follows' => $this->follows_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
