<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\ProfileResource;

class ProfileController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->user();
        if ($data->role !== 'Admin') {
            return $this->errorResponse('Unauthorized!', 403);
        }
        $admin = User::where('id', $data->id)->first();
        return $this->successResponse(content: new ProfileResource($admin));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
