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

        if ($user->isBlocked()) {
            return response()->json(['success' => false, 'error' => 'Your account was blocked'], 401);
        }

        $userId = $user->id;
        $roleId = $user->role_id;
        $fullName = $user->first_name . ' ' . $user->last_name;
        $rating = 0;
        $shipper = [];
        if ($user->isShipper()) {
            $shipper_id = Auth::user()->shipper()->first()->id;
            $is_online = $rating = Auth::user()->shipper()->first()->is_online;
            $shipper = [
                'shipper_id' => $shipper_id,
                'is_online' => $is_online
            ];
            $rating = Auth::user()->shipper()->first()->rating;

        } else {

        }
        $data = [
            'token' => $token,
            'user_id' => $userId,
            'full_name' => $fullName,
            'rating' => $rating,
            'role_id' => $roleId
        ];
        $data = array_merge($data, $shipper);

        return response()->json(['success' => true, 'data'=> $data]);
    }

    public function logout(Request $request) {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
