<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthController extends ApiController
{
    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $this->validate($request, $rules);

        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        // all good so return the token
        $user = Auth::user();
        $userId = $user->id;
        $fullName = $user->first_name . ' ' . $user->last_name;
        $rating = 0;

        if ($user->isShipper()) {
            $rating = Auth::user()->shipper()->first()->rating;
        } else {

        }

        $data = [ 'token' => $token, 'user_id' => $userId, 'full_name' => $fullName, 'rating' => $rating];

        return response()->json(['success' => true, 'data'=> $data]);
    }

    public function logout(Request $request) {
        $payload = JWTAuth::parseToken()->getPayload();
        $expires_at = date('d M Y h:i', $payload->get('exp'));
        return response()->json(['hoan' => $expires_at], 200);
    }
}
