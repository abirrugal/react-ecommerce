<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = auth()->user();

        return apiResourceResponse(UserResource::make($profile));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'min:2'],
            'last_name' => ['required', 'string', 'min:2'],
            'username' => ['required', 'string', 'min:2'],
            'phone' => ['required', 'regex:/(01)[0-9]{9}/', 'exists:users,phone', 'max:11'],
            'email' => ['required', 'email'],
        ]);
        if ($validator->fails()) {
            return  errorResponse($validator->errors()->first(), 422);
        }
        $user = auth()->user();
        $input = $validator->validated();
        $user->update($input);

        return  apiResourceResponse(UserResource::make(auth()->user()), 'Your profile update successfully');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required', 'min:6'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['min:6'],
        ]);

        if ($validator->fails()) {
            return  errorResponse($validator->errors()->first(), 422);
        }

        $user = auth()->user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->update(['password' => Hash::make($request->password)]);
        } else {
            return  errorResponse('Old password is wrong', 401);
        }

        return successResponse('Password Update successfully');
    }
}
