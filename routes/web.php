<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\DashboardController;
use \App\Http\Controllers\UsersController;
use \App\Http\Controllers\CustomersController;
use \App\Http\Controllers\ProductsController;
use \App\Http\Controllers\OrdersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function () {

    Route::resources([
        '/' => DashboardController::class,
        '/orders' => OrdersController::class,
        '/customers' => CustomersController::class,
        '/products' => ProductsController::class,
    ]);


    Route::group([ 'middleware' => ['isSuperAdmin']], function () {

        Route::resources([
            'users' => UsersController::class,
        ]);

    });


});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::post('/user/logout', [UsersController::class, 'logout']);

Route::post('/customers/delete', [CustomersController::class, 'delete']);
Route::post('/products/delete', [ProductsController::class, 'delete']);
Route::post('/users/delete', [UsersController::class, 'delete']);
Route::post('/products/upload-product-image', [ProductsController::class, 'ProductImageUpload']);

Route::post('/orders/add-this-to-cart', [OrdersController::class, 'addToCart']);
Route::post('/orders/update-this-to-cart', [OrdersController::class, 'updateCart']);
Route::post('/orders/delete-this-cart-item', [OrdersController::class, 'deleteCartItem']);
Route::post('/orders/products-filter', [OrdersController::class, 'productsFilter']);
Route::post('/orders/delete', [OrdersController::class, 'delete']);
Route::post('/orders/add-this-to-order', [OrdersController::class, 'addToOrder']);
Route::post('/orders/update-this-to-order', [OrdersController::class, 'updateOrder']);
Route::post('/orders/delete-this-order-item', [OrdersController::class, 'deleteOrderItem']);

require __DIR__.'/auth.php';
