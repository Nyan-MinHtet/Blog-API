<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
                'name'          => $this->name,
                'email'         => $this->email,
                'role'          => $this->role,
                'totalPublicPost'    => $this->whenLoaded(
                             'posts',
                                    fn($posts) => $posts->where('status', 'Public')->count()
                ),
                'totalPrivatePost'    => $this->whenLoaded(
                             'posts',
                                    fn($posts) => $posts->where('status', 'Private')->count()
                ),
        ];
    }
}
