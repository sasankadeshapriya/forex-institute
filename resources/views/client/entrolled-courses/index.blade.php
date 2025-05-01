@extends('client.layouts.main')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Enrolled Courses</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">Enrolled Courses</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
                @if($continueCourseId)
                  <a href="{{ route('entrolled-courses.show', $continueCourseId) }}"
                     class="btn btn-primary"
                     style="border-radius: 5px;">
                    Continue Learning
                  </a>
                @else
                  <button class="btn btn-primary" disabled style="border-radius: 5px;">
                    Continue Learning
                  </button>
                @endif
            </div>
            <div class="card-body">
              <div class="row g-4">
                <!-- Course Card Start -->
                @foreach($coursesWithProgress as $course)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ route('entrolled-courses.show', $course->id) }}" class="text-decoration-none text-dark">
                      <div class="card course-card h-100 shadow-sm border-0">
                        <div class="position-relative">
                          <img src="{{ asset('storage/' . $course->image) }}"
                               class="card-img-top course-thumb"
                               alt="Course Thumbnail" />
                          <button class="btn btn-play rounded-circle shadow">
                            <i class="fas fa-play"></i>
                          </button>
                        </div>
                        <div class="card-body">
                          <h5 class="card-title mb-2 text-truncate">{{ $course->name }}</h5>
                          <p class="card-text mb-1 text-muted small">
                            <i class="fas fa-user me-1"></i> {{ $course->instructor_name }}
                          </p>
                          <p class="card-text mb-0 text-muted small">
                            <i class="fas fa-clock me-1"></i> {{ $course->duration }} hours
                          </p>

                          <!-- Show Progress -->
                          <div class="mb-2">
                            <div class="progress" style="height: 6px; border-radius: 3px;">
                              <div class="progress-bar" role="progressbar" style="width: {{ $course->progress }}%;" aria-valuenow="{{ $course->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">{{ number_format($course->progress, 2) }}% completed</small>
                          </div>

                        </div>
                      </div>
                    </a>
                  </div>
                @endforeach
              </div>
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
  .course-card {
    background: #f5f6fb;
    border-radius: 1rem;
    transition: box-shadow 0.2s, transform 0.2s;
  }

  .course-card:hover {
    box-shadow: 0 6px 24px rgba(103, 119, 239, 0.15);
    transform: translateY(-2px) scale(1.01);
  }

  .course-thumb {
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    height: 180px;
    object-fit: cover;
    width: 100%;
  }

  .btn-play {
    width: 48px;
    height: 48px;
    background: #6777ef;
    color: #fff;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.92;
    border: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transition: background 0.2s, transform 0.2s;
    z-index: 2;
  }

  .btn-play:hover{
    background: #4e5ed3;
  }

  .card-title {
    color: #222;
    font-weight: 600;
  }

  .card-text i {
    color: #6777ef;
  }

  .btn:not(.btn-social):not(.btn-social-icon):active, .btn:not(.btn-social):not(.btn-social-icon):focus, .btn:not(.btn-social):not(.btn-social-icon):hover {
    border-color: transparent !important;
    background-color: #858ed1;
  }

  a.text-decoration-none:hover {
  text-decoration: none !important;
  }


</style>
@endpush