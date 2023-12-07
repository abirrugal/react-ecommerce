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
    });

    // Route::prefix('product')->group(function() {
    //     Route::get('/',[ProductController::class,'index'])->name('product');
    //     Route::get('add',[ProductController::class,'add'])->name('product.add');
    //     Route::post('store',[ProductController::class,'store'])->name('product.store');
    //     Route::get('{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    //     Route::post('{id}/update', [ProductController::class, 'update'])->name('product.update');
    //     Route::get('show/{product}', [ProductController::class, 'show'])->name('product.show');
    //     Route::post('multiImage/update', [ProductController::class, 'multiImageUpdate'])->name('product.multiImage.update');
    //     Route::get('delete/multiImage/{id}', [ProductController::class, 'multiImageDelete'])->name('product.multiImage.delete');
    //     Route::get('{id}/inactive', [ProductController::class, 'productInactive'])->name('product.inactive');
    //     Route::get('inactive',[ProductController::class,'productAllInactive'])->name('all.inactive.product');
    // });

    Route::get('orders', [OrderController::class, 'index'])->name('order');
    Route::get('order/{order}/show', [OrderController::class, 'show'])->name('order.details');
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');

    Route::get('users', [UserController::class, 'index'])->name('user');
    Route::get('user/inactive/{id}', [UserController::class, 'inactive'])->name('user.inactive');
    Route::get('inactive/user',[UserController::class,'allInactive'])->name('all.inactive.user');
    Route::get('user/active/{id}', [UserController::class, 'active'])->name('user.active');
});

