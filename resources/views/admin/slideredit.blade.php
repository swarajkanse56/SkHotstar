@extends('admin.master')

@section('title', isset($slider) ? 'Edit Slider' : 'Create Slider')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            {{ isset($slider) ? 'Edit Slider' : 'Create New Slider' }}
                        </h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="container">
                        <form 
                            action="{{ isset($slider) ? route('sliders.update', $slider->id) : route('sliders.store') }}" 
                            method="POST" 
                            enctype="multipart/form-data"
                            class="p-4">
                            
                            @csrf
                            @if(isset($slider))
                                @method('PUT')
                            @endif

                            <!-- Slider Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label">Slider Name</label>
                                <div class="input-group input-group-outline">
                                    <input 
                                        type="text" 
                                        name="name" 
                                        id="name" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        value="{{ old('name', $slider->name ?? '') }}" 
                                        required
                                        placeholder="Enter slider name">
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Video Dropdown -->
                            <div class="mb-4">
                                <label for="video_id" class="form-label">Select Video</label>
                                <div class="input-group input-group-outline">
                                    <select 
                                        name="video_id" 
                                        id="video_id" 
                                        class="form-control @error('video_id') is-invalid @enderror" 
                                        required>
                                        <option value="">-- Choose a Video --</option>
                                        @foreach($videos as $video)
                                            <option 
                                                value="{{ $video->id }}" 
                                                {{ old('video_id', $slider->video_id ?? '') == $video->id ? 'selected' : '' }}>
                                                {{ $video->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('video_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Thumbnail Upload -->
                            <div class="mb-4">
                                <label for="thumbnail" class="form-label">Thumbnail</label>
                                <div class="input-group input-group-outline">
                                    <input 
                                        type="file" 
                                        name="thumbnail" 
                                        id="thumbnail" 
                                        class="form-control @error('thumbnail') is-invalid @enderror"
                                        accept="image/*">
                                </div>
                                @error('thumbnail')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                                @if(isset($slider) && $slider->thumbnail)
                                    <div class="mt-3">
                                        <label class="form-label">Current Thumbnail:</label>
                                        <div class="card card-body p-2" style="max-width: 250px;">
                                            <img src="{{ asset('storage/' . $slider->thumbnail) }}" 
                                                alt="Thumbnail" 
                                                class="img-fluid rounded">
                                            <div class="d-flex justify-content-between mt-2">
                                                <span class="badge bg-gradient-info">Current</span>
                                                <span class="text-xs text-secondary">Click to replace</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('sliders.index') }}" class="btn btn-light me-2">
                                    <i class="material-icons me-1">arrow_back</i> Cancel
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="material-icons me-1">{{ isset($slider) ? 'update' : 'save' }}</i>
                                    {{ isset($slider) ? 'Update Slider' : 'Create Slider' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(195deg, #42424a 0%, #191919 100%);
    }
    
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.1);
    }
    
    .input-group-outline {
        position: relative;
        background-color: transparent;
        border-radius: 8px;
    }
    
    .input-group-outline .form-control {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 10px 15px;
        transition: all 0.3s;
    }
    
    .input-group-outline .form-control:focus {
        background-color: #fff;
        border-color: #4a4a4a;
        box-shadow: 0 0 0 2px rgba(74, 74, 74, 0.2);
    }
    
    .btn-success {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }
    
    .btn-success:hover {
        background-color: #3d8b40;
        border-color: #3d8b40;
    }
    
    .btn-light {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
    }
    
    .material-icons {
        vertical-align: middle;
        font-size: 18px;
    }
</style>
@endsection