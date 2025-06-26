@extends('admin.master')

@section('title', 'All Videos')

@section('content')
<div class="container-fluid px-4">

    <!-- Add New Video Button at the top right -->
    <div class="d-flex justify-content-end my-3">
        <a href="{{ route('videos.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add New Video
        </a>
    </div>

    <div class="card mt-2">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0"><i class="fas fa-video me-2"></i>Video Management</h3>
        </div>

         <div class="d-flex justify-content-end my-3">
        <a href="{{ route('videos.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add New Video
        </a>
    </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Thumbnail</th>
                            <th>Videos</th>
                            <th>Category</th>
                            <th>SubCategory</th>
                            <th>Duration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($videos as $video)
                        <tr>
                            <td>#{{ $video->id }}</td>
                            <td>
                                <strong>{{ Str::limit($video->title, 30) }}</strong>
                                @if($video->featured)
                                    <span class="badge bg-warning text-dark ms-2">Featured</span>
                                @endif
                            </td>
                            <td>
                                @if($video->thumbnail)
                                    <img src="{{ asset($video->thumbnail) }}" alt="Thumb" class="img-thumbnail" width="60">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($video->video_url)
                                    @php
                                        $url = $video->video_url;
                                        $isYoutube = Str::contains($url, ['youtube.com/watch', 'youtu.be']);
                                        $isVimeo = Str::contains($url, 'vimeo.com');
                                    @endphp

                                    @if($isYoutube)
                                        @php
                                            if (preg_match('/youtu\.be\/([^\?&]+)/', $url, $matches)) {
                                                $youtubeId = $matches[1];
                                            } elseif (preg_match('/v=([^\&]+)/', $url, $matches)) {
                                                $youtubeId = $matches[1];
                                            } else {
                                                $youtubeId = null;
                                            }
                                        @endphp
                                        @if($youtubeId)
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                                                <img src="https://img.youtube.com/vi/{{ $youtubeId }}/mqdefault.jpg" 
                                                     alt="Video Thumbnail" width="80" class="rounded">
                                            </a>
                                        @endif

                                        <!-- Modal -->
                                        <div class="modal fade" id="videoModal{{ $video->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ $video->title }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="ratio ratio-16x9">
                                                            <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=0" 
                                                                    allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($isVimeo)
                                        @php
                                            preg_match('/vimeo\.com\/(\d+)/', $url, $matches);
                                            $vimeoId = $matches[1] ?? null;
                                        @endphp
                                        @if($vimeoId)
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                                                <img src="https://vumbnail.com/{{ $vimeoId }}.jpg" 
                                                     alt="Video Thumbnail" width="80" class="rounded">
                                            </a>
                                        @endif

                                        <!-- Modal -->
                                        <div class="modal fade" id="videoModal{{ $video->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ $video->title }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="ratio ratio-16x9">
                                                            <iframe src="https://player.vimeo.com/video/{{ $vimeoId }}" 
                                                                    frameborder="0" allow="autoplay; fullscreen" allowfullscreen>
                                                            </iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                                            <i class="fas fa-play-circle fs-3 text-primary"></i>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="videoModal{{ $video->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ $video->title }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="ratio ratio-16x9">
                                                            <video controls class="w-100">
                                                                <source src="{{ asset($url) }}" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $video->category->name ?? 'N/A' }}</span>
                            </td>
                            <td>
    @if($video->subcategory)
        <span class="badge bg-secondary">{{ $video->subcategory->name }}</span>
    @else
        <span class="text-muted">N/A</span>
    @endif
</td>
                            <td>{{ gmdate("i:s", $video->duration) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('videos.show', $video->id) }}" 
                                       class="btn btn-info" 
                                       data-bs-toggle="tooltip" 
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('videos.edit', $video->id) }}" 
                                       class="btn btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('videos.destroy', $video->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this video?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(method_exists($videos, 'hasPages') && $videos->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $videos->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection

@endsection
