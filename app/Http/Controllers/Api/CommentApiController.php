<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\CommentValidateRequest;
use App\Http\Resources\Api\Author\CommentResource;

class CommentApiController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function show($id)
    {
         $comment = Comment::with('user')->where('post_id', $id)->get();
         return $this->successResponse(content: CommentResource::collection($comment),status: 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentValidateRequest $request)
    {
        $validated = $request->validated();
        if ($request->post_id) {
            $post = Post::find($request->post_id);
            if (!$post) {
            return $this->errorResponse('Post not found!', 404);
        }
        }
        $this->authorize('addComment', $post);
        $validated['user_id'] = Auth::id();
        $validated['post_id'] = $request->post_id;
        $comment = Comment::create($validated);
        return $this->successResponse(content: $comment, status: 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentValidateRequest $request, Comment $comment)
    {
        $validated = $request->validated();
        $this->authorize('update' , $comment);
        $comment->update($validated);
        return $this->successResponse(content: $comment , status: 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
