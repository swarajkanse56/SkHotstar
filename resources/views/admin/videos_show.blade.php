@extends('admin.master')

@section('title', $video->title)

@section('content')
<div class="container mt-4">
    <h2>{{ $video->title }}</h2>

    {{-- Thumbnail --}}
    @if($video->thumbnail)
        <img src="{{ asset($video->thumbnail) }}" alt="Thumbnail" style="max-width: 300px; margin-bottom: 20px;">
    @endif

    {{-- Metadata --}}
    <p><strong>Category:</strong> {{ $video->category->name ?? 'N/A' }}</p>
    <p><strong>Subcategory:</strong> {{ $video->subcategory->name ?? 'N/A' }}</p>
    <p><strong>Duration:</strong> {{ $video->duration ?? 'N/A' }} seconds</p>
    <p><strong>Description:</strong> {!! nl2br(e($video->description)) !!}</p>

    <hr>

    {{-- Wishlist button --}}
    @auth
        @php
            $inWishlist = auth()->user()->wishlist()->where('video_id', $video->id)->exists();
        @endphp

        @if($inWishlist)
            <button class="btn btn-success" disabled>✓ Added to Wishlist</button>
        @else
            <form action="{{ route('wishlist.store') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="video_id" value="{{ $video->id }}">
                <button type="submit" class="btn btn-primary">♡ Add to Wishlist</button>
            </form>
        @endif
    @else
        <a href="{{ route('login') }}" class="btn btn-primary">Login to add to Wishlist</a>
    @endauth

    <hr>

    {{-- Video player --}}
    @php
        $url = $video->video_url;
        $isYoutube = str_contains($url, 'youtube.com/watch') || str_contains($url, 'youtu.be');
        $isVimeo = str_contains($url, 'vimeo.com');
    @endphp

    @if($isYoutube)
        @php
            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/', $url, $matches);
            $youtubeId = $matches[1] ?? null;
        @endphp

        @if($youtubeId)
            <iframe width="720" height="405" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allowfullscreen></iframe>
        @else
            <p class="text-danger">Invalid YouTube URL.</p>
        @endif

    @elseif($isVimeo)
        @php
            preg_match('/vimeo\.com\/(\d+)/', $url, $matches);
            $vimeoId = $matches[1] ?? null;
        @endphp

        @if($vimeoId)
            <iframe src="https://player.vimeo.com/video/{{ $vimeoId }}" width="720" height="405" frameborder="0" allowfullscreen></iframe>
        @else
            <p class="text-danger">Invalid Vimeo URL.</p>
        @endif

    @else
        <video width="720" height="405" controls>
            <source src="{{ asset($url) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    @endif
</div>
@endsection
