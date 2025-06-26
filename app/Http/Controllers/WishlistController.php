<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Wishlists;

class WishlistController extends Controller
{
    // Store a video to wishlist
    public function store(Request $request)
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
        ]);

        $user = Auth::user();

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
                          ->where('video_id', $request->video_id)
                          ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => $user->id,
                'video_id' => $request->video_id,
            ]);
        }

        return back()->with('success', 'Video added to your wishlist!');
    }

    // Show the wishlist page (optional) 
 
public function getWishlist(Request $request)
{
    $user = Auth::user();  // or $request->user() if using sanctum

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized',
        ], 401);
    }

    // Get wishlist with related video info
    $wishlistVideos = $user->wishlist()->with('video')->get();

    return response()->json([
        'success' => true,
        'data' => $wishlistVideos,
    ]);
}





}
