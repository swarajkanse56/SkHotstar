<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Videos;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    // List all videos
    public function index()
{
    // Eager load category and subcategory relationships to avoid N+1 queries
    $videos = Videos::with(['category', 'subcategory'])
                    ->orderBy('id', 'asc')
                    ->get();

    // Pass data to the Blade view
    return view('admin.videos_list', compact('videos'));
}


    // Show form to create a new video
    public function create(Request $request)
    {
        $categories = Category::all();
        $selectedCategoryId = $request->old('category_id') ?? $request->input('category_id');

        $subcategories = collect();
        if ($selectedCategoryId) {
            $subcategories = SubCategory::where('category_id', $selectedCategoryId)->get();
        }

        return view('admin.video_form', compact('categories', 'subcategories', 'selectedCategoryId'));
    }

    // Store a new video
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'thumbnail'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url'      => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'description'    => 'nullable|string',
            'duration'       => 'nullable|integer',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/thumbnails'), $filename);
            $thumbnailPath = 'uploads/thumbnails/' . $filename;
        }

        Videos::create([
            'title'         => $request->title,
            'thumbnail'     => $thumbnailPath,
            'video_url'     => $request->video_url,
            'category_id'   => $request->category_id,
            'subcategory_id'=> $request->subcategory_id,
            'description'   => $request->description,
            'duration'      => $request->duration,
        ]);

        return redirect()->route('videos.index')->with('success', 'Video added successfully!');
    }

    // Show details of a specific video
    public function show($id)
    {
        $video = Videos::with('category', 'subcategory')->findOrFail($id);
        return view('admin.videos_show', compact('video'));
    }

    // Show form to edit a video
 public function edit($id)
{
    $video = Videos::findOrFail($id);
    $categories = Category::all();
    $subcategories = Subcategory::all(); // All subcategories

    return view('admin.video_edit', compact('video', 'categories', 'subcategories'));
}


    // Update an existing video
   public function update(Request $request, $id)
{
    $video = Videos::findOrFail($id);

    $request->validate([
        'title'          => 'required|string|max:255',
        'thumbnail'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // optional
        'video_url'      => 'nullable|string|max:255',
        'category_id'    => 'required|exists:categories,id',
        'subcategory_id' => 'nullable|exists:subcategories,id',
        'duration'       => 'nullable|numeric', // removed 'required' here
    ]);

    $video->title = $request->title;
    $video->video_url = $request->video_url;
    $video->category_id = $request->category_id;
    $video->subcategory_id = $request->subcategory_id;

    // Only update duration if present, else keep existing value
    if ($request->filled('duration')) {
        $video->duration = $request->duration;
    }

    if ($request->hasFile('thumbnail')) {
        $file = $request->file('thumbnail');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/thumbnails'), $filename);
        $video->thumbnail = 'uploads/thumbnails/' . $filename;
    }

    $video->save();

    return redirect()->route('videos.index')->with('success', 'Video updated successfully!');
}




public function destroy($id)
{
    $video = Videos::findOrFail($id);

    // Optionally, delete the thumbnail file from storage if exists
    if ($video->thumbnail && file_exists(public_path($video->thumbnail))) {
        unlink(public_path($video->thumbnail));
    }

    $video->delete();

    return redirect()->route('videos.index')->with('success', 'Video deleted successfully!');
}


    // Return subcategories for selected category (used in AJAX)
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }




    
}
