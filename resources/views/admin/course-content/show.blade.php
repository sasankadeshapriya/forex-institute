@extends('admin.layouts.main')

@section('content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Course Content</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></div>
        <div class="breadcrumb-item">Manage</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                  <form action="{{ route('admin.course-content.store', $course->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="heading">Content Heading</label>
                        <input type="text" class="form-control @error('heading') is-invalid @enderror" id="heading" name="heading" placeholder="Heading" value="{{ old('heading') }}">
                        @error('heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group col-md-6">
                        <label for="content_type">Content Type</label>
                        <select class="form-control" id="content_type" name="content_type">
                            <option value="" disabled selected>Select Content Type</option>
                            <option value="video" {{ old('content_type') == 'video' ? 'selected' : '' }}>Video</option>
                            <option value="pdf" {{ old('content_type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                            <option value="file" {{ old('content_type') == 'file' ? 'selected' : '' }}>File</option>
                            <option value="text" {{ old('content_type') == 'text' ? 'selected' : '' }}>Text</option>
                        </select>
                      </div>
                    </div>

                    <!-- Show when select content type text -->
                    <div class="form-group" id="text_content" style="display: {{ old('content_type') == 'text' ? 'block' : 'none' }};">
                      <label for="content">Input Your Content</label>
                      <textarea class="summernote @error('content') is-invalid @enderror" name="content" id="content">{{ old('content') }}</textarea>
                      @error('content')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <!-- Show when select content type file/pdf -->
                    <div class="form-group custom-file" id="file_content" style="display: {{ old('content_type') == 'pdf' || old('content_type') == 'file' ? 'block' : 'none' }};">
                      <input type="file" class="custom-file-input @error('content') is-invalid @enderror" id="content_file" name="content_file" accept="application/pdf, application/zip">
                      <label class="custom-file-label" for="content_file">Choose File when PDF or File Type</label>
                      @error('content_file')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <!-- Show when select content type video -->
                    <div class="form-group" id="video_content" style="display: {{ old('content_type') == 'video' ? 'block' : 'none' }};">
                      <label for="video_link">Video Link *add GoogleDrive Link</label>
                      <input type="text" class="form-control @error('video_link') is-invalid @enderror" id="video_link" name="video_link" placeholder="Google Drive Link" value="{{ old('video_link') }}">
                      @error('video_link')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="order">Order</label>
                      <input type="number" class="form-control" id="order" name="order" value="{{ $nextOrder }}" readonly>
                    </div>

                    <div class="card-footer" style="padding-left: 0px;">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                  </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
              <div class="card-body">

                  <!-- Show/Hide data -->

                  @foreach ($contents as $content)
                  <div class="card">
                      <div class="card-header" style='border-color:#f9f9f9; background-color: #e9ecef;'>
                      <h4>
                          {{ $content->heading }}
                          <span class="badge" style='color: #6C757D; background-color: #cdd3d7;'>{{ ucfirst($content->content_type) }}</span>
                      </h4>
                      <div class="card-header-action">
                          <a data-collapse="#panel-{{ $content->id }}" class="btn-sm" href="#" style="border-radius: 0px !important;"><i class="fas fa-plus"></i></a>
                          <a href="{{ route('admin.course-content.moveUp', $content->id) }}" class="btn-sm" style="border-radius: 0px !important;">
                            <i class="fa fa-arrow-up"></i>
                          </a>
                          <a href="{{ route('admin.course-content.moveDown', $content->id) }}" class="btn-sm" style="border-radius: 0px !important;">
                            <i class="fa fa-arrow-down"></i>
                          </a>
                      </div>
                      </div>
                      <div class="collapse" id="panel-{{ $content->id }}">
                      {{-- <div class="card-body">
                        @if ($content->content_type == 'text')
                        {!! $content->content !!}
                        @elseif ($content->content_type == 'video')
                            <iframe src="{{ $content->content }}" width="100%" height="400"></iframe>
                        @elseif ($content->content_type == 'pdf' || $content->content_type == 'file')
                            <a href="{{ route('file.download', basename($content->content)) }}" target="_blank">Download</a>
                        @endif
                      </div> --}}
                      <div class="card-body">
                        @if ($content->content_type == 'text')
                            <!-- Display Text Content with Rich HTML -->
                            <div class="content-text">
                                {!! $content->content !!} <!-- Allow HTML rendering -->
                            </div>

                        @elseif ($content->content_type == 'video')
                            <!-- Embed Google Drive Video Link -->
                            <div class="content-video">
                                @php
                                    // Extract Google Drive file ID from the URL
                                    preg_match('/\/d\/(.*?)(?:\/|$)/', $content->content, $matches);
                                    $videoId = $matches[1] ?? null;
                                @endphp

                                @if ($videoId)
                                    <iframe src="https://drive.google.com/file/d/{{ $videoId }}/preview" width="100%" height="400"></iframe>
                                @else
                                    <p>Video link is invalid or missing the file ID.</p>
                                @endif
                            </div>

                        @elseif ($content->content_type == 'file')
                            <!-- Show File Information, File Size, Name and Provide Download Link -->
                            <div class="content-file">
                                @php
                                    $filePath = storage_path('app/private/' . $content->content);
                                    $fileSize = is_file($filePath) ? formatBytes(filesize($filePath)) : ''; // Function to format file size
                                @endphp

                                <p><strong>File Name:</strong> {{ basename($content->content) }}</p>
                                <p><strong>File Size:</strong> {{ $fileSize }}</p>

                                <!-- Download Link -->
                                <a href="{{ route('file.download', basename($content->content)) }}" target="_blank">Download</a>
                            </div>

                            @elseif ($content->content_type == 'pdf')
                            <!-- Embed PDF with Navigation and Download Option -->
                            <div class="content-pdf">
                                <!-- Embed PDF directly using the streaming route -->
                                <embed src="{{ route('file.stream', basename($content->content)) }}" type="application/pdf" width="100%" height="600px">
                                <p>
                                    <a href="{{ route('file.download', basename($content->content)) }}" class="btn btn-primary" target="_blank">Download PDF</a>
                                </p>
                            </div>
                            @endif

                      </div>
                      <div class="card-footer">
                          <div class="card-footer" style="padding-left: 0px;">
                            <form action="{{ route('admin.course-content.destroy', $content->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-icon btn-info"><i class="ion-trash-a"></i></button>
                            </form>
                        </div>
                      </div>
                      </div>
                  </div>
                  @endforeach

              </div>
              <div class="card-footer text-left">
                <form action="{{ route('admin.course-content.deleteAll', $course->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete All</button>
                </form>
              </div>
            </div>
        </div>
      </div>
    </div>

  </section>
</div>

@endsection

@push('styles')
    <style>
        .btn-info, .btn-info.disabled {
            box-shadow: 0 2px 6px #E3EAEF;
            background-color: #cdd3d7;
            border-color: #E3EAEF;
            color: #6C757D;
        }

        .btn-info:hover, .btn-info:focus, .btn-info:active, .btn-info.disabled:hover, .btn-info.disabled:focus, .btn-info.disabled:active {
            background-color: #cdd3d7 !important;
        }

        .card-header h4 .badge {
            font-size: 8px;
            margin-left: 10px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('content_type').addEventListener('change', function() {
            var contentType = this.value;
            document.getElementById('text_content').style.display = contentType === 'text' ? 'block' : 'none';
            document.getElementById('file_content').style.display = (contentType === 'pdf' || contentType === 'file') ? 'block' : 'none';
            document.getElementById('video_content').style.display = contentType === 'video' ? 'block' : 'none';
        });
    </script>
@endpush

@php
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $power = floor(($bytes ? log($bytes) : 0) / log(1024));
    return number_format($bytes / pow(1024, $power), $precision) . ' ' . $units[$power];
}
@endphp

