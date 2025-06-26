@extends('admin.master')

@section('title', 'Add Category')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div style="width: 400px;">
        <h2 class="mb-4 text-center">Add New Category</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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

        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-control" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus
                >
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Category Image (Optional)</label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    class="form-control" 
                    accept="image/*"
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">Save Category</button>
        </form>
    </div>
</div>
@endsection
