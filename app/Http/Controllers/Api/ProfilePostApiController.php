<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\PostValidateRequest;
use App\Http\Resources\Api\Author\PostResource;

class ProfilePostApiController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(config('pagination.perPage'));

        return $this->successResponse(
            'Post retreived successfully!',
            $this->buildPaginatedResponse(PostResource::class,$posts));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostValidateRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);

        $recentlyPosted = Post::create($validated);

        return $this->successResponse('success', $recentlyPosted,201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostValidateRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        try{
            $validated = $request->validated();
        if ($validated['title'] !== $post->title) {
            $title = $validated['title'];
            $validated['slug'] = Str::slug($title);
        }
        $post->update($validated);
        }catch(Exception $error){
            return $this->errorResponse($error->getMessage(), 500);
        };
        
        return $this->successResponse(
            'Post updated successfully!',
            $post,
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return $this->successResponse(message: 'Successfully Destroy!', status: 200);
    }  
}
