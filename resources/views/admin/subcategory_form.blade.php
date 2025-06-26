@extends('admin.master')

@section('title', 'Add Subcategory')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Add Subcategory</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('subcategory.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Subcategory Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Subcategory Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        {{-- Parent Category --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Select Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Choose Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Image Upload --}}
        <div class="mb-3">
            <label for="image" class="form-label">Subcategory Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        {{-- Status Checkbox --}}
       
        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">Save Subcategory</button>
    </form>
</div>
@endsection
