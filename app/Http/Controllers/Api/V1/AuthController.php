<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\V1\UserResource;

class AuthController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/(01)[0-9]{9}/|exists:users,phone|max:11',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return errorResponse($validator->errors()->first(), 422);
        }

        if(!Auth::attempt($request->only(['phone', 'password']))){

            return errorResponse('Incorrect password', 422);
        }

        $user = User::where('phone', $request->phone)->first();

        $response['user'] = UserResource::make($user);
        $response['token'] = $user->createToken("API TOKEN")->plainTextToken;

        return apiResponse($response, 'Login Successful', 200);
    }

    public function register(Request $request){

        try {

            $validator = Validator::make($request->all(),
            [
                'first_name' => 'required|string|min:3|max:100',
                'last_name' => 'required|string|min:3|max:100',
                'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users,phone|max:11',
                'password' => 'required|min:6|confirmed'
            ]);

            if($validator->fails()){
                return errorResponse($validator->errors()->first(), 422);
            }

            $username = Str::slug($request->first_name.'.'.$request->last_name, '-');

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $username,
                'phone' => $request->phone,
                'role' => User::USER,
                'password' => Hash::make($request->password)
            ]);

            $response['user'] = UserResource::make($user);
            $response['token'] = $user->createToken("API TOKEN")->plainTextToken;

            return apiResponse($response, 'Registration Successful', 201);

        } catch (\Throwable $th) {

            return errorResponse($th->getMessage(), 500);
        }
    }

    public function logout(){

        Auth::user()->tokens()->delete();

        return apiResponse([], 'Logged out successfully');
    }
}
