<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostSoftResource extends JsonResource
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
            'upvote' => $this->upvotes_count,
            'comments' => $this->comments_count,
            "content" => $this->content,
            'is_liked' => $this->userLiked ? true : false,
            'is_upvoted' => $this->userUpvoted ? true : false,
            'finished_at' => $this->finished_at,
            'created_at' => $this->created_at,
        ];
    }
}
