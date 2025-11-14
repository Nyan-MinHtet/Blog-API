<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\ProfilePostApiController;

Route::post('/v1/auth/login', [AuthController::class, 'login']);

Route::prefix('v1/')->group(function (){
    Route::middleware(['auth:sanctum', "role.check:Author"])->group(function () {
    Route::apiResource('/authors/posts', PostApiController::class)->only('index', 'show');
    Route::apiResource('/authors/profiles/posts', ProfilePostApiController::class)->except( 'show');
});
});


