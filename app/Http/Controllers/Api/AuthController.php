<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use ApiResponse, HasApiTokens; 
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' =>  'required|email',
                'password' => 'required|min:6|regex:/[0-9]/|regex:/[a-zA-Z]/'
            ]
        );
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }
        $validatedData = $validator->validated();
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->errorResponse('Your credentials have not served!', 404);
        }

        if (!Hash::check($validatedData['password'], $user->password)) {
            return $this->errorResponse('Your credential is wrong!', 401);
        }
        try {
            $accessToken = $user->createToken('accessToken', ['*'], now()->addHour())->plainTextToken;
            $refreshToken = Str::random(64);
            $user->update([
                'refresh_token' => Hash::make($refreshToken),
                'refresh_token_expires_at' => Carbon::now()->addDays(15),
            ]);
            $content = [
                'user' => $user,
                'access-token' => $accessToken,
            ];
            return $this->successResponse("You've successfully login to your account!", $content, 200)->withCookie(cookie(
                'refreshToken',                 // cookie name
                $refreshToken,                   // cookie value
                60 * 24 * 15,                    // minutes (15 days)
                '/',                             // path
                null,                            // domain
                app()->isLocal() ? false : true, // secure => local false
                true,                            // httpOnly
                false,                           // raw
                'Strict'                         // SameSite           // SameSite option (Strict / Lax / None)
            ));
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), 500);
        }
    }
}
