<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required','string'],
            'phone' => ['required', 'numeric', 'digits_between:8,15'],
            'email' => ['required', 'email'],
            'message' => ['required', 'min:2'],
        ]);

        if($validator->fails()){
            return errorResponse($validator->errors()->first(), 422);
        }

        ContactUs::create($validator->validated());

        return successResponse('Your message sent successfully');
    }

}
