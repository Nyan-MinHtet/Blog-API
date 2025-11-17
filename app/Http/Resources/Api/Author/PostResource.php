<?php

namespace App\Http\Resources\Api\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'content'       => $this->content,
            'status'        => $this->status,
            'user_id'       => $this->user_id,
            'series_id'     => $this->series_id,
            'category_id'   => $this->category_id
        ];
    }
}
