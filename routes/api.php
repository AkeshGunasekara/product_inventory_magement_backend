<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route to display a list of products
    Route::get('/products', [ProductController::class, 'index']);

    // Route to display a form for creating a new product
    Route::get('/products/create', [ProductController::class, 'create']);

    // Route to handle the creation of a new product
    Route::post('/products', [ProductController::class, 'store']);

    // Route to display details of a specific product
    Route::get('/products/{product}', [ProductController::class, 'show']);

    // Route to display a form for editing a specific product
    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);

    // Route to handle the update of a specific product
    Route::put('/products/{product}', [ProductController::class, 'update']);

    // Route to handle the deletion of a specific product
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
});

