<?php
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\AttributeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Route::group(function(){
    Route::get('/login',[LoginController::class,'show'])->name('login');
    Route::post('/login',[LoginController::class,'login']);
// });

Route::group(['prefix'=> 'admin'], function(){

    Route::get('logout',[LoginController::class,'logout'])->name('logout');
    Route::get('dashboard',[LoginController::class,'dashboard'])->name('admin.dashboard');

    Route::prefix('category')->controller(CategoryController::class)->name('category.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{id}/edit',  'edit')->name('edit');
        Route::put('/{id}',  'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
        Route::get('/{category}/subcategories', 'getSubCategory');
    });

    Route::prefix('subcategory')->controller(SubCategoryController::class)->name('subcategory.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{id}/edit',  'edit')->name('edit');
        Route::put('/{id}',  'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    Route::prefix('brand')->controller(BrandController::class)->name('brand.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{id}/edit',  'edit')->name('edit');
        Route::put('/{id}',  'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    Route::prefix('attribute')->controller(AttributeController::class)->name('attribute.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{id}/edit',  'edit')->name('edit');
        Route::put('/{id}',  'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
    });
    Route::prefix('product')->controller(ProductController::class)->name('product.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{id}/edit',  'edit')->name('edit');
        Route::put('/{id}',  'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
        Route::get('/images/{id}/delete', 'deleteImage');
        Route::post('/{id}/addimage', 'addImage');
    });

    Route::prefix('order')->controller(OrderController::class)->name('order.')->group(function() {
        Route::get('/', 'index')->name('index');
        // Route::get('/create', 'create')->name('create');
        // Route::post('/',  'store')->name('store');
        // Route::get('/{id}/edit',  'edit')->name('edit');
        // Route::put('/{id}',  'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    // Route::get('orders', [OrderController::class, 'index'])->name('order');
    // Route::get('order/{order}/show', [OrderController::class, 'show'])->name('order.details');
    // Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');

    Route::get('users', [UserController::class, 'index'])->name('user');
    Route::get('user/inactive/{id}', [UserController::class, 'inactive'])->name('user.inactive');
    Route::get('inactive/user',[UserController::class,'allInactive'])->name('all.inactive.user');
    Route::get('user/active/{id}', [UserController::class, 'active'])->name('user.active');
});

