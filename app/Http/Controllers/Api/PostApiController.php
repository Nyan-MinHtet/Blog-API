<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Helpers\PostValidateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Helper\FormatterHelper;

class PostApiController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('status', 'Public')->get();

        return $this->successResponse(
            'Success',
            $posts,
            200
        );
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
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostValidateRequest $request, Post $post)
    {
        try{
            $validated = $request->validated();
            $validated['user_id'] = Auth::id();
        if ($validated['title'] !== $post->title) {
            $title = $validated['title'];
            $validated['slug'] = Str::slug($title);
        }
        $post->update($validated);
        }catch(Exception $error){
            return $this->errorResponse($error->getMessage());
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
        //
    }    
    
    private function validation($data){
        $rule = [
            'title'         => 'required', 
            'content'       => 'required',
            'user_id'       => 'required',
            'status'        => 'sometimes | in:Public,Private',
        ];
        $validator = Validator::make($data, $rule);
        $validated = $validator->validated();
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }
        return $validated;
    }
}


