<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Admin\AuthorUpdateValidateRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\Admin\AuthorResource;

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
    public function update(User $author , AuthorUpdateValidateRequest $request)
    {
        $this->authorize($author);
        $validated = $request->validated();
        $author->update($validated);
        return $this->successResponse(content: $author);
    }

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(User $user)
    //{
        //
    //}
}
