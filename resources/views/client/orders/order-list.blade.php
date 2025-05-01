@extends('client.layouts.main')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Order List</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">Orders</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Your Orders</h4>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-md">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Course Name</th>
                      <th>Created At</th>
                      <th>Status</th>
                      <th>Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $order)
                      <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->course->name }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>
                          <!-- Dynamically assign badge based on status -->
                          @if ($order->status == 'rejected')
                            <div class="badge badge-danger">Rejected</div>
                          @elseif ($order->status == 'processing')
                            <div class="badge badge-primary">Processing</div>
                          @elseif ($order->status == 'pending')
                            <div class="badge badge-primary">Pending</div>
                          @else
                            <div class="badge badge-success">Completed</div>
                          @endif
                        </td>
                        <td>
                          <div class="badge badge-light">${{ $order->amount }}</div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer text-right">
              <!-- Pagination links -->
              {{ $orders->links() }} <!-- This will automatically display pagination links -->
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

</style>
@endpush
