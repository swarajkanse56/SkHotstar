<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegistersController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DownloadController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\VideosController;
use App\Http\Controllers\Api\WishlistController;

// ✅ Public routes (no token required)
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegistersController::class, 'register']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/subcategories', [SubcategoryController::class, 'index']);
Route::get('/videos', [VideosController::class, 'index']);
Route::get('/videos/{id}', [VideosController::class, 'show']);
// Route::get('/videos/download/{id}', [VideosController::class, 'download']);

// ✅ Protected routes (token required via Laravel Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Wishlist routes - only for logged-in users
    Route::get('/wishlist', [WishlistController::class, 'getWishlist']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::post('/wishlist/remove', [WishlistController::class, 'remove']);

    // Slider list
    Route::get('/sliders', [SliderController::class, 'index']);
 Route::post('/downloads/{videoId}', action: [DownloadController::class, 'store']);
    Route::get('/downloads', [DownloadController::class, 'index']); // GET API for download list

     Route::delete('/downloads/{videoId}', [DownloadController::class, 'destroy']);

 


    // Authenticated user info
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'user' => $request->user(),
        ]);
    });
});
