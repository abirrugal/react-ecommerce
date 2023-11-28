<?php

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

if(!function_exists('getImageUrl')){
    function getImageUrl($image = null){
        if($image == null) return asset('images/default.png');

        return asset('images/'.$image);
    }
}

if(!function_exists('apiResponse')) {
    function apiResponse(object|array $data, string|null $message=null, int $statusCode=200)
    {
        $response['status'] = true;

        if(isset($message)) $response['message'] = $message;
        if(!empty($data)) $response['data'] = $data;

        return response()->json($response, $statusCode);
    }
}

if(!function_exists('successResponse')) {
    function successResponse(string $message, int $statusCode=200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
        ], $statusCode);
    }
}

if(!function_exists('errorResponse')) {
    function errorResponse(string $message, int $statusCode=400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $statusCode);
    }
}

if(!function_exists('apiResourceResponse')) {
    function apiResourceResponse(object $collection, string|null $message=null, int $statusCode=200, array $extraData = [])
    {
        $response['status'] = true;
        if(isset($message)) $response['message'] = $message;
        if(!empty($extraData)) $response['extraData'] = $extraData;
        $collection = $collection->additional($response)->response()->getData();

        return response()->json($collection, $statusCode);
    }
}

if(!function_exists('validationError')) {
     function validationError(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status' => false,
            'code' => 422,
            'message' => 'Validation error',
            'data'    => $validator->errors()
        ] , 422));
    }
}
