<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\Api\Admin\AuthorResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = User::where('role', 'Author')
        ->orderBy('created_at', 'desc')
        ->paginate(config('pagination.perPage'));
        $authors->load('posts');
        return $this->buildPaginatedResponse(AuthorResource::class, $authors);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(User $author)
    {
        $author->load('posts');
        return $this->successResponse(content: new AuthorResource($author));
    } 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(User $user)
    //{
        //
    //}
}
