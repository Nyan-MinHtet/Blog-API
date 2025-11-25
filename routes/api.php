<?php

use App\Http\Controllers\Api\Admin\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\ProfilePostApiController;

Route::post('/v1/auth/login', [AuthController::class, 'login'])
                        ->name('auth.login')
                        ->middleware('suspended.check');

Route::prefix('v1/')->group(function ()
{

    Route::middleware(['auth:sanctum', "role.check:Author" , "suspended.check"])->group(function () 
    {

        Route::apiResource('/authors/posts', PostApiController::class)->only('index', 'show');
        Route::apiResource('/authors/posts/comments', CommentApiController::class)->except('index');
        Route::apiResource('/authors/profiles/posts', ProfilePostApiController::class)->except('show');
    
    });

    Route::middleware(['auth:sanctum', "role.check:Admin"])->group(function () {
    Route::apiResource('/admin/authors', AuthorController::class)->except('store');
});
});


