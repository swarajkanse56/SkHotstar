@extends('admin.master')

@section('title', 'Add Video')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-4">Add New Video</h2>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Category selection form to reload page and fetch subcategories --}}
    <form method="GET" action="{{ route('videos.create') }}">
        <div class="mb-3">
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" class="form-control" onchange="this.form.submit()">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ (old('category_id') == $cat->id || (isset($selectedCategoryId) && $selectedCategoryId == $cat->id)) ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    {{-- Actual form to add video --}}
    <form method="POST" action="{{ route('videos.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Pass selected category to store --}}
        <input type="hidden" name="category_id" value="{{ old('category_id', $selectedCategoryId ?? '') }}">

        <div class="mb-3">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input type="text" id="title" name="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="thumbnail">Thumbnail (optional)</label>
            <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="video_url">Video URL <span class="text-danger">*</span></label>
            <input type="text" id="video_url" name="video_url" class="form-control" required value="{{ old('video_url') }}">
        </div>

        <div class="mb-3">
            <label for="subcategory_id">Subcategory</label>
            <select id="subcategory_id" name="subcategory_id" class="form-control">
                <option value="">Select Subcategory</option>
                @foreach($subcategories as $subcat)
                    <option value="{{ $subcat->id }}" {{ old('subcategory_id') == $subcat->id ? 'selected' : '' }}>
                        {{ $subcat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description">Description (optional)</label>
            <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="duration">Duration (seconds, optional)</label>
            <input type="number" id="duration" name="duration" class="form-control" min="0" value="{{ old('duration') }}">
        </div>

        <button type="submit" class="btn btn-primary w-100">Save Video</button>
    </form>
</div>
@endsection
