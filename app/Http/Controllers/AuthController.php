<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials, $request->remember)) {
                $token = Auth::user()->createToken('auth_token')->plainTextToken;
                return response()->json([
                        'status' => true,
                        'message' => config('api-messages.success.common'),
                        'data' => [
                            'token-type' => 'Bearer',
                            'api-token' => $token
                        ]
                    ])->withCookie(cookie('TOKEN', $token, 1 * 60 * 24 * 2));
            }

            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
                'data' => []
            ], 401);
        } catch (\Exception $exception) {
            $sentry = app('sentry');
            $sentryId = $sentry->captureException($exception);
            return response()->json([
                'status' => false,
                'message' => 'Error in Login',
                'error' => $exception->getMessage(),
                'sentryId' => (string) $sentryId
            ]);
        }
    }

    public function logout(){
        try {
            auth()->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully'
            ], 401);
        } catch (\Exception $exception){
            dd($exception);
            return response()->json([
                'status' => false,
                'message' => 'Cannot sign out.'
            ], 401);
        }
    }
}
