@extends('admin.master')

@section('title', 'My Wishlist')

@section('content')
<div class="container mt-4">
    <h2>My Wishlist</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($wishlistVideos->isEmpty())
        <p>You have no videos in your wishlist.</p>
    @else
        <div class="row">
            @foreach($wishlistVideos as $item)
                @php
                    $video = $item->video;
                    $url = $video->video_url;
                    $isYoutube = strpos($url, 'youtube.com/watch') !== false || strpos($url, 'youtu.be') !== false;
                    $isVimeo = strpos($url, 'vimeo.com') !== false;
                @endphp

                <div class="col-md-6 mb-4">
                    <div class="card">
                        @if($video->thumbnail)
                            <img src="{{ asset($video->thumbnail) }}" class="card-img-top" alt="Thumbnail">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $video->title }}</h5>
                            <p class="card-text">
                                <strong>Category:</strong> {{ $video->category->name ?? 'N/A' }}<br>
                                <strong>Subcategory:</strong> {{ $video->subcategory->name ?? 'N/A' }}<br>
                                <strong>Duration:</strong> {{ $video->duration ?? 'N/A' }} seconds
                            </p>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($video->description), 100) }}</p>

                            {{-- Embedded video --}}
                            @if($isYoutube)
                                @php
                                    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/', $url, $matches);
                                    $youtubeId = $matches[1] ?? null;
                                @endphp
                                @if($youtubeId)
                                    <iframe width="100%" height="250" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allowfullscreen></iframe>
                                @else
                                    <p>Invalid YouTube URL.</p>
                                @endif

                            @elseif($isVimeo)
                                @php
                                    preg_match('/vimeo\.com\/(\d+)/', $url, $matches);
                                    $vimeoId = $matches[1] ?? null;
                                @endphp
                                @if($vimeoId)
                                    <iframe src="https://player.vimeo.com/video/{{ $vimeoId }}" width="100%" height="250" frameborder="0" allowfullscreen></iframe>
                                @else
                                    <p>Invalid Vimeo URL.</p>
                                @endif

                            @else
                                <video width="100%" height="250" controls>
                                    <source src="{{ asset($url) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif

                            <a href="{{ route('videos.show', $video->id) }}" class="btn btn-primary mt-3">Watch Full</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
