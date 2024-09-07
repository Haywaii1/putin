<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// PUBLIC ROUTE
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');


// PRIVATE ROUTE
Route::group(["middleware" => ['auth:sanctum']], function(){
    Route::post('/add-product', [ProductController::class, 'addProduct'])->name('add.product');
Route::get('/all-products', [ProductController::class, 'allProducts'])->name('all.products');
Route::post('/update-product/{id}', [ProductController::class, 'updateProduct'])->name('update.product');
Route::delete('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('delete.product');
});
