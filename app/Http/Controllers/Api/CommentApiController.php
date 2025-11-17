<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\Api\Author\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
