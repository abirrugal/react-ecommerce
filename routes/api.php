<?php

use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\ContactUsController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WishlistController;
use App\Http\Controllers\DeliveryChargeController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function(){

    //===================Auth=================>>
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->prefix('user')->group(function(){
    Route::resource('address', AddressController::class);
    Route::get('profile', [UserController::class, 'index']);
    Route::post('profile/update', [UserController::class, 'update']);
    Route::post('password/update', [UserController::class, 'changePassword']);
    });

    Route::get('payment-method', [PaymentMethodController::class, 'index']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('subCategories/{category}', [CategoryController::class, 'subCategories']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('product/{slug}', [ProductController::class, 'show']);
    Route::get('products/search', [ProductController::class, 'productSearch']);



    Route::get('notifications', [NotificationController::class,'index'])->middleware('auth:sanctum');
    Route::get('setting', [SettingController::class,'setting']);

    Route::middleware('auth:sanctum')->prefix('order')->group(function(){
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'order']);
        Route::get('/{order}', [OrderController::class, 'show']);
        Route::post('/{order}/cancelled', [OrderController::class, 'orderCancel']);
    });

    Route::middleware('auth:sanctum')->prefix('cart')->group(function(){
        Route::get('/', [CartController::class, 'index']);
        Route::get('/store', [CartController::class, 'store']);
        Route::get('/update/{cartItem}', [CartController::class, 'update']);
        Route::get('/delete/{cartItem}', [CartController::class, 'delete']);
    });

    Route::middleware('auth:sanctum')->prefix('wishlist')->group(function(){
        Route::get('/', [WishlistController::class, 'index']);
        Route::post('store', [WishlistController::class, 'store']);
        Route::delete('/delete/{product_id}', [WishlistController::class, 'delete']);
    });

    Route::prefix('review')->group(function(){
        Route::get('/', [ReviewController::class, 'index']);
        Route::post('store', [ReviewController::class, 'store'])->middleware('auth:sanctum');
        Route::post('update/{review}', [ReviewController::class, 'update'])->middleware('auth:sanctum');
    });

    Route::get('brand', [BrandController::class, 'index']);

    Route::post('contact/store', [ContactUsController::class, 'store']);
    Route::get('banner', [BannerController::class, 'index']);
    Route::get('region', [AddressController::class, 'region']);
    Route::get('city', [AddressController::class, 'city']);

});



Route::any('{catchall}', [
    function () {
        return response()->json([
            'status'=>false,
            'message'=>'No Endpoints Found!'
        ], 404);
    }
])->where('catchall', '.*');
