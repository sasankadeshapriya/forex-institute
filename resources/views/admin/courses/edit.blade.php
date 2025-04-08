@extends('admin.layouts.main')

@section('content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Edit Course</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></div>
        <div class="breadcrumb-item">Edit</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="card">
            <div class="card-body">
              <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Course Name" value="{{ old('name', $course->name) }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="instructorName">Instructor Name</label>
                    <input type="text" class="form-control @error('instructor_name') is-invalid @enderror" id="instructorName" name="instructor_name" placeholder="Instructor Name" value="{{ old('instructor_name', $course->instructor_name) }}">
                    @error('instructor_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="form-group">
                  <label for="description">Course Description</label>
                  <textarea class="summernote @error('description') is-invalid @enderror" name="description">{{ old('description', $course->description) }}</textarea>
                  @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group custom-file">
                  <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept=".jpg,.png">
                  <label class="custom-file-label" for="image">{{ $course->image ?? 'Choose Image' }}</label>
                  @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <small id="fileName" class="form-text text-muted"></small>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                        <label for="lastUpdated">Last Updated</label>
                        <input type="text" class="form-control datepicker @error('last_updated') is-invalid @enderror" name="last_updated"
                        value="{{ old('last_updated', \Carbon\Carbon::parse($course->last_updated)->format('Y-m-d')) }}">
                        @error('last_updated')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label for="price">Price</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          $
                        </div>
                      </div>
                      <input type="text" class="form-control currency @error('price') is-invalid @enderror" name="price" value="{{ old('price', $course->price) }}">
                    </div>
                    @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label for="duration">Duration (in hours)</label>
                    <input type="number" min="1" step="1" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration', $course->duration) }}">
                    @error('duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="card-footer" style="padding-left: 0px;">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Back</a>
                </div>
              </form>
            </div>
          </div>
      </div>
    </div>

  </section>
</div>

@endsection

@section('scripts')
  <!-- Custom Scripts for Image File Preview -->
  <script>
    document.getElementById("image").addEventListener("change", function(event) {
        var fileName = event.target.files[0] ? event.target.files[0].name : 'Choose Image';
        var label = document.querySelector("label.custom-file-label[for='image']");
        if (label) label.innerText = fileName;
    });
  </script>

  <!-- Initialize Datepicker -->
  <script>
    $(document).ready(function() {
        // Initialize the date picker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
    });
  </script>
@endsection
