@extends('admin.master')

@section('title', 'Edit Subcategory')

@section('content')
<div class="container mt-4">
    <h2>Edit Subcategory</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('subcategory.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Subcategory Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $subcategory->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Parent Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Subcategory Image</label><br>
            @if ($subcategory->image && file_exists(public_path($subcategory->image)))
                <img src="{{ asset($subcategory->image) }}" width="100" alt="Current Image"><br><br>
            @endif
            <input type="file" name="image" id="image" class="form-control">
            <small class="text-muted">Leave blank to keep current image.</small>
        </div>

        <button type="submit" class="btn btn-success">Update Subcategory</button>
        <a href="{{ route('subcategory.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
