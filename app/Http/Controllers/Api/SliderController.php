<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    /**
     * Return all sliders with their related video data as JSON
     */
public function index()
{
    $sliders = Slider::all();

    $result = $sliders->map(function ($slider) {
        return [
            'id' => $slider->id,
            'name' => $slider->name,
            'video_id' => $slider->video_id,
            'thumbnail' => $slider->thumbnail ? url('storage/' . $slider->thumbnail) : null,
        ];
    });

    return response()->json(['data' => $result]);
}


}
