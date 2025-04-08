@extends('admin.layouts.main')

@section('content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Courses</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Courses</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <a href="{{ route('admin.courses.create') }}" class="btn btn-primary" style="border-radius: 5px;">
                Create
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-md">
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Instructor</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Last Update</th>
                    <th>Action</th>
                  </tr>

                  <!-- Loop through courses and display them -->
                  @foreach ($courses as $course)
                  <tr>
                    <td>{{ $course->id }}</td>
                    <td>
                      <!-- Display the image as a circle -->
                      <img src="{{ asset('storage/' . $course->image) }}" alt="course image" style="width: 50px; height: 50px; border-radius: 50%;">
                    </td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->instructor_name }}</td>
                    <td><div class="badge badge-light">${{ $course->price }}</div></td>
                    <td>{{ $course->duration }} Hours</td>
                    <td>{{ $course->updated_at->format('Y-m-d') }}</td>
                    <td>
                      <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-primary">View</a>
                      <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-primary">Edit</a>
                      <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </table>
              </div>
            </div>
            <div class="card-footer text-right">
              <!-- Pagination links -->
              <nav class="d-inline-block">
                {{ $courses->links() }}
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>

@endsection
