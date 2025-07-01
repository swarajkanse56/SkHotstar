<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{



    public function index()
{
    $downloads = Download::with(['user', 'video'])->latest('downloaded_at')->get();
    return view('admin.downloadslist', compact('downloads'));
}

    public function store(Request $request, $videoId)
    {
        $user = Auth::user();
        $video = Videos::findOrFail($videoId);

        // Check if the user already downloaded this video
        $alreadyDownloaded = Download::where('user_id', $user->id)
            ->where('video_id', $video->id)
            ->exists();

        if ($alreadyDownloaded) {
            return redirect()->back()->with('info', 'You have already downloaded this video.');
        }

        // Assume video is stored locally and path is valid
        $filePath = $video->video_url; // Adjust based on your logic
        $fileName = basename($filePath);
        $fullPath = public_path($filePath);
        $fileSize = file_exists($fullPath) ? filesize($fullPath) : 'unknown';

        // Store download record
        Download::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => (string) $fileSize,
            'downloaded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Download recorded successfully!');
    }
}
