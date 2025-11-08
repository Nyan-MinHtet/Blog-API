<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostApiController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all()->where('status', 'Public');

        return $this->successResponse(
            'Success',
            $posts,
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = [
            'title'         => 'required', 
            'content'       => 'required',
            'user_id'       => 'required',
        ];
        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $title = $request->title;
        $slug = Str::slug($title);

        $validated = $validator->validate();
        
        $data = [
            'title'         => $validated['title'],
            'slug'          => $slug,
            'content'       => $validated['content'],
            'user_id'       => $validated['user_id'],
            'series_id'     => $request->series_id,
            'category_id'   => $request->category_id,
        ];
        $recentlyPosted = Post::create($data);

        return $this->successResponse('success', $recentlyPosted,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }    
}


