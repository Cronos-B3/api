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
            'likes' => $this->likes_count,
            'upvote' => $this->upvotes_count,
            "content" => $this->content,
            'finished_at' => $this->finished_at,
            'created_at' => $this->created_at,
        ];
    }
}
