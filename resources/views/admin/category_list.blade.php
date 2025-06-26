@extends('admin.master')

@section('title', 'Category List')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Categories</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('category.create') }}" class="btn btn-primary mb-3">Add New Category</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Actions</th> {{-- New Actions Column --}}
            </tr>
        </thead>
       <tbody>
    @forelse($categories as $category)
        <tr>
            <td>{{ $loop->iteration }}</td> {{-- Serial number --}}
            <td>{{ $category->name }}</td>
            <td>
                @if($category->image)
                    <img src="{{ asset($category->image) }}" width="60" alt="{{ $category->name }}">
                @else
                    <span>No Image</span>
                @endif
            </td>
            <td>{{ $category->created_at->format('d M Y') }}</td>
            <td>
                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete this category?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">No categories found.</td>
        </tr>
    @endforelse
</tbody>

    </table>
</div>
@endsection
