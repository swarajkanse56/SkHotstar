@extends('admin.master')

@section('title', 'Edit Video')

@section('content')
<div class="container mt-4" style="max-width: 700px;">
    <h2 class="mb-4">Edit Video</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Video Title</label>
            <input type="text" id="title" name="title" class="form-control"
                value="{{ old('title', $video->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label><br>
            @if($video->thumbnail)
                <img src="{{ asset($video->thumbnail) }}" width="120" class="mb-2 rounded">
                <br>
            @endif
            <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
            <small class="text-muted">Leave empty to keep the current thumbnail.</small>
        </div>

        <div class="mb-3">
            <label for="video_url" class="form-label">Video URL</label>
            <input type="text" id="video_url" name="video_url" class="form-control"
                value="{{ old('video_url', $video->video_url) }}" required>
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" name="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $video->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Subcategory --}}
        <div class="mb-3">
            <label for="subcategory_id" class="form-label">Subcategory</label>
            <select id="subcategory_id" name="subcategory_id" class="form-select">
                <option value="">-- Select Subcategory --</option>
                @foreach($subcategories as $subcat)
                    <option value="{{ $subcat->id }}"
                        data-category="{{ $subcat->category_id }}"
                        {{ old('subcategory_id', $video->subcategory_id) == $subcat->id ? 'selected' : '' }}>
                        {{ $subcat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Duration (seconds)</label>
            <input type="number" id="duration" name="duration" class="form-control" min="0"
                value="{{ old('duration', $video->duration) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Video</button>
        <a href="{{ route('videos.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('subcategory_id');

        function filterSubcategories() {
            const selectedCategoryId = categorySelect.value;

            Array.from(subcategorySelect.options).forEach(option => {
                if (option.value === '') return option.hidden = false;

                const belongsToCategory = option.getAttribute('data-category') === selectedCategoryId;
                option.hidden = !belongsToCategory;

                // Reset if not matching
                if (!belongsToCategory && option.selected) {
                    option.selected = false;
                }
            });
        }

        categorySelect.addEventListener('change', filterSubcategories);

        // Run on page load to hide irrelevant subcategories
        filterSubcategories();
    });
</script>
@endsection
