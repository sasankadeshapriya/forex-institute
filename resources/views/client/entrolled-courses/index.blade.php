@extends('client.layouts.main')

@section('content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Entrolled Courses</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Entrolled Courses</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <a href="#" class="btn btn-primary" style="border-radius: 5px;">
                Continoue Learning
              </a>
            </div>
            <div class="card-body">

            </div>
            <div class="card-footer text-right">

            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>

@endsection
