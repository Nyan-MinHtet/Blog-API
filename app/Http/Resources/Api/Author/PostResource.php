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
            'user'          => $this->whenLoaded('user' , fn($user) => $user->name),
            'series'        => $this->whenLoaded('series',  fn($series) => $series->title),
            'category'      => $this->whenLoaded('category', fn($category) => $category->name),
            'createdAt'     => $this->created_at,
            'updatedAt'    => $this->updated_at
        ];
    }
}
