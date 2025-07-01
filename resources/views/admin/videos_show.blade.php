@extends('admin.master')

@section('title', $video->title)

@section('content')
<div class="container mt-4">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">{{ $video->title }}</h2>
        </div>

        <div class="card-body">
            {{-- Thumbnail --}}
            @if($video->thumbnail)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/'.$video->thumbnail) }}"
                         alt="Thumbnail"
                         class="img-fluid rounded"
                         style="max-height: 300px;">
                </div>
            @endif

            {{-- Metadata --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Category:</strong> {{ $video->category->name ?? 'N/A' }}</p>
                    <p><strong>Subcategory:</strong> {{ $video->subcategory->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Duration:</strong> {{ gmdate("i:s", $video->duration) ?? 'N/A' }}</p>
                    <p><strong>Views:</strong> {{ number_format($video->views) }}</p>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <h5>Description</h5>
                <div class="border p-3 rounded bg-light">
                    {!! nl2br(e($video->description)) !!}
                </div>
            </div>

            <hr>

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                {{-- Wishlist button --}}
                <div>
                    @auth
                        @php
                            $inWishlist = auth()->user()->wishlist()->where('video_id', $video->id)->exists();
                        @endphp

                        @if($inWishlist)
                            <button class="btn btn-success" disabled>
                                <i class="fas fa-check"></i> In Your Wishlist
                            </button>
                        @else
                            <form action="{{ route('wishlist.store') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="video_id" value="{{ $video->id }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-heart"></i> Add to Wishlist
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login to add to Wishlist
                        </a>
                    @endauth
                </div>

                {{-- Download button with count --}}
                <div>
                    @auth
                        @php
                            $downloadCount = $video->downloads()->count();
                            $userDownloaded = $video->downloads()->where('user_id', auth()->id())->exists();
                        @endphp

                        <form action="{{ route('video.download', $video->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-download"></i>
                                Download
                                @if($downloadCount > 0)
                                    <span class="badge bg-secondary ms-1">{{ $downloadCount }}</span>
                                @endif
                            </button>
                        </form>

                        @if($userDownloaded)
                            <span class="ms-2 text-success">
                                <i class="fas fa-check-circle"></i> Downloaded
                            </span>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning">
                            <i class="fas fa-sign-in-alt"></i> Login to Download
                        </a>
                    @endauth
                </div>
            </div>

            <hr>

            {{-- Video Player --}}
            <div class="ratio ratio-16x9 mb-4">
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
                        <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    @else
                        <div class="alert alert-danger">Invalid YouTube URL.</div>
                    @endif

                @elseif($isVimeo)
                    @php
                        preg_match('/vimeo\.com\/(\d+)/', $url, $matches);
                        $vimeoId = $matches[1] ?? null;
                    @endphp

                    @if($vimeoId)
                        <iframe src="https://player.vimeo.com/video/{{ $vimeoId }}"
                                frameborder="0"
                                allow="autoplay; fullscreen; picture-in-picture"
                                allowfullscreen></iframe>
                    @else
                        <div class="alert alert-danger">Invalid Vimeo URL.</div>
                    @endif

                @else
                    <video controls class="w-100">
                        <source src="{{ asset('storage/'.$video->video_file) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
