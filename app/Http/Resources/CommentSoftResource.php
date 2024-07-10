<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentSoftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'user_id' => $this->user_id,
            'username' => $this->user->username,
            'profile_picture' => $this->user->profile_picture,
            'likes' => $this->likes_count,
            'content' => $this->content,
            'is_liked' => $this->userLiked ? true : false,
        ];
    }
}
