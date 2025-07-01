@extends('admin.master')

@section('title', 'Download List')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Download List</h2>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($downloads->isEmpty())
        <div class="alert alert-info">No downloads found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Video Title</th>
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Downloaded At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($downloads as $index => $download)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $download->user->name ?? 'N/A' }}<br>
                                <small>{{ $download->user->email ?? '' }}</small>
                            </td>
                            <td>
                                {{ $download->video->title ?? 'N/A' }}
                                <br>
                                <a href="{{ route('videos.show', $download->video_id) }}" class="btn btn-sm btn-outline-info mt-1">
                                    View Video
                                </a>
                            </td>
                            <td>{{ $download->file_name }}</td>
                            <td>
                                @if(is_numeric($download->file_size))
                                    {{ round($download->file_size / 1024 / 1024, 2) }} MB
                                @else
                                    {{ $download->file_size }}
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($download->downloaded_at)->format('Y-m-d H:i') }}</td>
                            <td>
                                {{-- Optional: Delete Download --}}
                                {{-- <form action="{{ route('downloads.destroy', $download->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete this download record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
