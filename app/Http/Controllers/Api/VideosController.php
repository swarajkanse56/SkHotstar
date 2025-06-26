<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Videos;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $categoryId = $request->query('category_id');
    $subcategoryId = $request->query('subcategory_id');

    $query = Videos::with(['category', 'subcategory'])->orderBy('id', 'desc');

    // ✅ Filter by subcategory_id if provided
    if ($subcategoryId) {
        $query->where('subcategory_id', $subcategoryId);
    }

    // ✅ Else filter by category_id if provided
    elseif ($categoryId) {
        $query->where('category_id', $categoryId);
    }

    $videos = $query->get();

    return response()->json([
        'status' => true,
        'videos' => $videos,
    ]);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
  public function show($id)
    {
        $video = Videos::with('category', 'subcategory')->find($id);

        if (!$video) {
            return response()->json([
                'success' => false,
                'message' => 'Video not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $video
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
