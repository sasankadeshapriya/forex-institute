@extends('client.layouts.main')

@section('content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="card">
          <div class="card-header">
            <h4>
                Keep Learning <i class="fas fa-fire" style="color: #ff5722;"></i>
            </h4>
          </div>
          <div class="card-body">
            <!-- Last Purchase Card -->
            <div class="card shadow-sm border-0 d-flex flex-row overflow-hidden" style="border-radius: 1rem; background: #e6e7eb;">
              <div class="thumbnail-container position-relative" style="width: 40%; min-height: 160px;">
                <img
                  src="https://images.unsplash.com/photo-1513258496099-48168024aec0?auto=format&fit=crop&w=400&q=80"
                  alt="Course Thumbnail"
                  class="img-fluid h-100 w-100"
                  style="object-fit: cover; border-top-left-radius: 1rem; border-bottom-left-radius: 1rem;"
                />
                <button
                  class="btn btn-play rounded-circle shadow"
                  title="Continue"
                >
                  <i class="fas fa-play"></i>
                </button>
              </div>
              <div class="flex-grow-1">
                <div class="card-body">
                  <h5 class="card-title mb-1 text-truncate" style="color: #222; font-weight: 600;">React for Beginners</h5>
                  <p class="mb-1 small" style="color: #6c757d;">
                    <i class="fas fa-user me-1" style="color: #6777ef;"></i> Emily Carter
                  </p>
                  <p class="mb-2 small" style="color: #6c757d;">
                    <i class="fas fa-clock me-1" style="color: #6777ef;"></i> 10 hours
                  </p>
                  <div class="mb-2">
                    <div class="progress" style="height: 6px; border-radius: 3px;">
                      <div class="progress-bar" role="progressbar" style="width: 60%; background: #6777ef;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted">60% completed</small>
                  </div>
                  <a href="#" class="btn btn-sm" style="background: #6777ef; color: #fff; border-radius: 2rem; font-weight: 500;">
                    Continue
                  </a>
                </div>
              </div>
            </div>
            <!-- End Last Purchase Card -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection

@push('styles')
<style>
  .btn-play {
    width: 40px;
    height: 40px;
    background: #6777ef;
    color: #fff;
    font-size: 1.2rem;
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

  .btn-play:hover,
  .btn-play:focus {
    background: #4e5ed3;
    transform: translate(-50%, -50%) scale(1.1);
  }

  .btn:not(.btn-social):not(.btn-social-icon):active, .btn:not(.btn-social):not(.btn-social-icon):focus, .btn:not(.btn-social):not(.btn-social-icon):hover {
    border-color: transparent !important;
    background-color: #858ed1;
  }

  @media (max-width: 576px) {
    .thumbnail-container {
      width: 100% !important;
      min-height: 140px;
    }
  }
</style>
@endpush
