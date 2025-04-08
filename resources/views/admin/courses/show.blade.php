@extends('admin.layouts.main')

@section('content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Course Details</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></div>
        <div class="breadcrumb-item">Show</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>{{ $course->name }}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}" class="img-fluid">
                </div>
                <div class="col-md-8">
                  <p><strong>Instructor:</strong> {{ $course->instructor_name }}</p>
                  <p><strong>Description:</strong> {{ $course->description }}</p>
                  <p><strong>Price:</strong> ${{ $course->price }}</p>
                  <p><strong>Duration:</strong> {{ $course->duration }} hours</p>
                  <p><strong>Last Updated:</strong> {{ \Carbon\Carbon::parse($course->last_updated)->format('Y-m-d') }}</p>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Back</a>
              <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>

@endsection
