<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegistersController;
use App\Http\Controllers\Api\CategoryController;
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

// ✅ Protected routes (token required via Laravel Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Wishlist routes - only accessible for authenticated users
    Route::get('/wishlist', [WishlistController::class, 'getWishlist']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::post('/wishlist/remove', [WishlistController::class, 'remove']); // <- add this


    // Authenticated user info
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'user' => $request->user(),
        ]);
    });
});
