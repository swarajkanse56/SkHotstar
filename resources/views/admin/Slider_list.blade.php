@extends('admin.master')

@section('title', 'Slider List')

@section('content')
<div class="container">
    <h2>Sliders</h2>
    <a href="{{ route('sliders.create') }}" class="btn btn-primary mb-3">Add New Slider</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($sliders->count())
        <div class="row">
            @foreach($sliders as $slider)
                <div class="col-md-4">
                    <div class="card mb-3">
                        @if($slider->thumbnail)
                            <img src="{{ asset('storage/' . $slider->thumbnail) }}"
                                 class="card-img-top"
                                 alt="Slider Thumbnail"
                                 style="height: 180px; object-fit: cover;">
                        @endif

                        <div class="card-body">
                            <h5>{{ $slider->name }}</h5>
                            <p><strong>Video:</strong> {{ $slider->video->title ?? 'N/A' }}</p>

                            @if($slider->video)
                                <a href="{{ route('videos.show', $slider->video->id) }}"
                                   class="btn btn-sm btn-success"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    <i class="fas fa-play-circle me-1"></i> Watch Video
                                </a>
                            @else
                                <span class="badge bg-secondary">No video URL</span>
                            @endif

                            <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Delete form -->
                            <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this slider?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No sliders available.</p>
    @endif
</div>
@endsection
