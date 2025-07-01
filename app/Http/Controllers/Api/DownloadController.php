<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // ✅ Don't forget to import this
use App\Models\Download;
use App\Models\Videos;
 use Illuminate\Support\Facades\Auth;


class DownloadController extends Controller
{


  

public function index(Request $request)
{
    // Get authenticated user
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized.',
        ], 401);
    }

    // Fetch downloads for this user, including video and user relations
    $downloads = Download::with(['user', 'video'])
        ->where('user_id', $user->id)
        ->orderByDesc('downloaded_at') // Use 'created_at' if 'downloaded_at' doesn't exist
        ->get();

    return response()->json([
        'status' => 'success',
        'message' => 'Download list retrieved successfully.',
        'data' => $downloads,
    ], 200);
}



public function destroy(Request $request, $videoId)
{
    $user = Auth::user();

    $download = \App\Models\Download::where('user_id', $user->id)
        ->where('video_id', $videoId)
        ->first();

    if (!$download) {
        return response()->json([
            'status' => 'error',
            'message' => 'Download not found.'
        ], 404);
    }

    $download->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Download removed successfully.'
    ]);
}



    public function store(Request $request, $videoId)
    {
        $user = $request->user(); // Token-based authenticated user
        $video = Videos::find($videoId);

        if (!$video) {
            return response()->json([
                'status' => 'error',
                'message' => 'Video not found.',
            ], 404);
        }

        $alreadyDownloaded = Download::where('user_id', $user->id)
            ->where('video_id', $video->id)
            ->exists();

        if ($alreadyDownloaded) {
            return response()->json([
                'status' => 'info',
                'message' => 'You have already downloaded this video.',
            ], 200);
        }

        $filePath = $video->video_url;
        $fileName = basename($filePath);
        $fullPath = public_path($filePath);
        $fileSize = file_exists($fullPath) ? filesize($fullPath) : 'unknown';

        Download::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => (string) $fileSize,
            'downloaded_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Download recorded successfully.',
            'data' => [
                'video_id' => $video->id,
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'file_path' => $filePath,
            ]
        ], 201);
    }
}
