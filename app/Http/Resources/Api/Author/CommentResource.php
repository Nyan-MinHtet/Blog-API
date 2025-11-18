<?php

namespace App\Http\Resources\Api\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'body'          => $this->body,
            'userName'      => $this->user->name,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
        ];
    }
}
