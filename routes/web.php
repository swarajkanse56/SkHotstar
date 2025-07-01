<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// Public or guest routes
Route::get('/', function () {
    return view('admin.master'); // Landing or welcome page
});

// Category Routes (RESTful)
Route::prefix('categories')->name('category.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');           // List all categories
    Route::get('/create', [CategoryController::class, 'create'])->name('create');    // Show form
    Route::post('/', [CategoryController::class, 'store'])->name('store');           // Store new category
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');     // Edit form
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update');      // Update
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy'); // Delete
    
});

// Subcategory Routes (RESTful)
Route::prefix('subcategories')->name('subcategory.')->group(function () {
    Route::get('/', [SubCategoryController::class, 'index'])->name('index');           // List all subcategories
    Route::get('/create', [SubCategoryController::class, 'create'])->name('create');   // Show create form
    Route::post('/', [SubCategoryController::class, 'store'])->name('store');          // Store new subcategory
    Route::get('/{id}/edit', [SubCategoryController::class, 'edit'])->name('edit');    // Edit form
    Route::put('/{id}', [SubCategoryController::class, 'update'])->name('update');     // Update
    Route::delete('/{id}', [SubCategoryController::class, 'destroy'])->name('destroy');// Delete

    // Fetch subcategories by category id (AJAX or dependent dropdown)
    Route::get('/by-category/{category_id}', [SubCategoryController::class, 'getByCategory'])->name('getByCategory');
});

// Video Routes (RESTful)
Route::prefix('videos')->name('videos.')->group(function () {
    Route::get('/', [VideosController::class, 'index'])->name('index');              // List all videos
    Route::get('/create', [VideosController::class, 'create'])->name('create');     // Create form
    Route::post('/', [VideosController::class, 'store'])->name('store');            // Store new video
    Route::get('/{video}', [VideosController::class, 'show'])->name('show');        // Show single video
    Route::get('/{video}/edit', [VideosController::class, 'edit'])->name('edit');   // Edit form
    Route::put('/{video}', [VideosController::class, 'update'])->name('update');    // Update video
    Route::delete('/{video}', [VideosController::class, 'destroy'])->name('destroy');// Delete video
 
});

// Authenticated routes (with middleware)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('admin.master');
    })->name('dashboard');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');

    // Show user's wishlist page
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
 
 
Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
Route::get('/sliders/create', [SliderController::class, 'create'])->name('sliders.create');  // fix URL: add slash before create
Route::post('/sliders', [SliderController::class, 'store'])->name('sliders.store');

Route::get('/sliders/{id}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
Route::put('/sliders/{id}', [SliderController::class, 'update'])->name('sliders.update');   // update route usually points to /sliders/{id} with PUT

Route::delete('/sliders/{id}', [SliderController::class, 'destroy'])->name('sliders.destroy');  // fix URL and param name consistency
Route::post('/videos/{video}/download', [DownloadController::class, 'store'])->name('video.download')->middleware('auth');
  Route::get('/download', [DownloadController::class, 'index'])->name('admin.downloads')->middleware('auth');

});
