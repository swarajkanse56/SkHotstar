@extends('admin.master')

@section('title', 'Edit Category')

@section('content')
<div class="container mt-4">
    <h2>Edit Category</h2>

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                value="{{ old('name', $category->name) }}"
                required
            >
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Category Image</label>
            <input
                type="file"
                name="image"
                id="image"
                class="form-control"
                accept="image/*"
            >
            @if($category->image && file_exists(public_path($category->image)))
                <img src="{{ asset($category->image) }}" alt="Category Image" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update Category</button>
        <a href="{{ route('category.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
