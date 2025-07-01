@extends('admin.master')

@section('title', 'Slider Form')

@section('content')
<div class="container">
    <h2>Create Slider</h2>

    {{-- Add enctype for file upload --}}
    <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Slider Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="video_id" class="form-label">Select Video</label>
            <select name="video_id" class="form-select" required>
                <option value="">-- Select Video --</option>
                @foreach($videos as $video)
                    <option value="{{ $video->id }}">{{ $video->title }}</option>
                @endforeach
            </select>
        </div>

        {{-- Thumbnail Upload --}}
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail Image</label>
            <input type="file" name="thumbnail" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-success">Create Slider</button>
    </form>
</div>
@endsection
