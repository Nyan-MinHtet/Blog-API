<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Author\PostResource;

class PostApiController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user' , 'series' , 'category')->where('status', 'Public')
                    ->orderBy('created_at', 'desc')
                    ->paginate(config('pagination.perPage'));

        return $this->successResponse(
            'Post retreived successfully!',
            $this->buildPaginatedResponse(PostResource::class,$posts));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $this->authorize('show', $post);
        $post->load(['user', 'series', 'category', 'comments']);
        return $this->successResponse('Post retrieved successfully!', new PostResource($post), 200);
    }

  
}


