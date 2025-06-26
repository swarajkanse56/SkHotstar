@extends('admin.master')

@section('title', 'Subcategory List')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Subcategories</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add New Subcategory Button --}}
    <a href="{{ route('subcategory.create') }}" class="btn btn-primary mb-3">Add New Subcategory</a>

    {{-- Subcategories Table --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>S.No.</th> {{-- Serial Number --}}
                <th>Subcategory Name</th>
                <th>Parent Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($subcategories->reverse() as $subcategory)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $subcategory->name }}</td>
                <td>{{ $subcategory->category->name ?? 'N/A' }}</td>
                <td>
                    @if($subcategory->image && file_exists(public_path($subcategory->image)))
                        <img src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->name }} Image" width="60" height="60">
                    @else
                        <span>No Image</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('subcategory.edit', $subcategory->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    
                    <form action="{{ route('subcategory.destroy', $subcategory->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No subcategories found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
