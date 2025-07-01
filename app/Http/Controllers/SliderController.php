<?php
namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::with('video')->get();
        return view('admin.Slider_list', compact('sliders'));
    }

    public function create()
    {
        $videos = Videos::all();
        return view('admin.Slider_form', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'video_id' => 'required|exists:videos,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only('name', 'video_id');

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        Slider::create($data);

        return redirect()->route('sliders.index')->with('success', 'Slider created successfully.');
    }

    // Show the edit form
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        $videos = Videos::all();
        return view('admin.slideredit', compact('slider', 'videos'));
    }

    // Update the slider
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'video_id' => 'required|exists:videos,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only('name', 'video_id');

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($slider->thumbnail && Storage::disk('public')->exists($slider->thumbnail)) {
                Storage::disk('public')->delete($slider->thumbnail);
            }
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        $slider->update($data);

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully.');
    }

    // Delete the slider
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        // Delete thumbnail file if exists
        if ($slider->thumbnail && Storage::disk('public')->exists($slider->thumbnail)) {
            Storage::disk('public')->delete($slider->thumbnail);
        }

        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully.');
    }
}
