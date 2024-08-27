<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\SignUpRequest;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(SignUpRequest $request){

        $params = $request->validated();

        $user = User::query()->create([
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'tg_username' => $params['tg_username'],
            'phone' => $params['phone'],
            'district_id' => $params['district_id'],
            'region_id' => $params['region_id'],
            'email' => $params['email'],
            'password' => bcrypt($params['password'])
        ]);

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];
        return response($res, 201);
    }

    public  function login(LoginRequest $request)
    {
        $params = $request->validated();
        $user = User::query()->where('email', $params['email'])->first();

        if (!$user || !Hash::check($params['password'], $user->password)) {
            return response([
                'error' => 'incorrect username or password'
            ], 401);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($res, 201);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return [
            'message' => 'user logged out'
        ];
    }
}
