<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    // Store video in wishlist for authenticated user
   public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'video_id' => 'required|integer|exists:videos,id',
    ]);

    $exists = Wishlist::where('user_id', $request->user_id)
                      ->where('video_id', $request->video_id)
                      ->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Already in wishlist.'
        ], 200);
    }

    Wishlist::create([
        'user_id' => $request->user_id,
        'video_id' => $request->video_id,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Video added to wishlist.',
    ], 201);
}


 public function getWishlist(Request $request)
{
    $user = $request->user(); // authenticated user from token

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }

    $wishlistVideos = $user->wishlist()->with('video')->get();

    return response()->json([
        'success' => true,
        'data' => $wishlistVideos,
    ]);
}


 
 public function remove(Request $request)
{
    $user = $request->user(); // or use auth()->user()
    $videoId = $request->video_id;

    $wishlist = Wishlist::where('user_id', $user->id)
                        ->where('video_id', $videoId)
                        ->first();

    if ($wishlist) {
        $wishlist->delete();
        return response()->json(['success' => true, 'message' => 'Removed from wishlist']);
    }

    return response()->json(['success' => false, 'message' => 'Video not found in wishlist']);
}



 




 
}
