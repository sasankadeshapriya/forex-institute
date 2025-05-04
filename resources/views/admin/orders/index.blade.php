@extends('admin.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Orders</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Orders</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Order List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Course Name</th>
                      <th>User</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Amount</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($orders as $order)
                    <tr>
                      <td>{{ $order->id }}</td>
                      <td>{{ $order->course->name }}</td>
                      <td>{{ $order->user->name }}</td>
                      <td>{{ $order->created_at->format('Y-m-d') }}</td>
                      <td>
                        @if ($order->status == 'rejected')
                          <span class="badge badge-danger">rejected</span>
                        @elseif ($order->status == 'pending')
                          <span class="badge badge-warning">pending</span>
                        @elseif ($order->status == 'confirmed')
                          <span class="badge badge-success">confirmed</span>
                        @else
                          <span class="badge badge-info">{{ ucfirst($order->status) }}</span>
                        @endif
                      </td>
                      <td>${{ number_format($order->amount, 2) }}</td>
                      <td>
                        <button class="btn btn-sm btn-primary" onclick="showOrderDetails({{ $order->id }})">
                          <i class="fas fa-eye"></i> Details
                        </button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Order Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <p><strong>Order ID:</strong> <span id="orderId"></span></p>
              <p><strong>User:</strong> <span id="userName"></span></p>
            </div>
            <div class="col-md-6">
              <p><strong>Course:</strong> <span id="courseName"></span></p>
              <p><strong>Date:</strong> <span id="orderDate"></span></p>
            </div>
          </div>

          <div class="mb-4">
            <h5>Payment Slip</h5>
            <div id="paymentSlip" class="border p-3 text-center bg-light">
              <p class="text-muted">Loading payment slip...</p>
            </div>
          </div>

          <div class="mb-3">
            <label for="paymentStatus"><strong>Payment Status:</strong></label>
            <select id="paymentStatus" class="form-control">
              <option value="pending">pending</option>
              <option value="confirmed">confirmed</option>
              <option value="rejected">rejected</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="updatePaymentStatus()">Save Changes</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('backend/assets/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>

<script src="{{ asset('backend/assets/js/page/modules-datatables.js') }}"></script>
<script>
    $(document).ready(function() {
    if ($.fn.dataTable.isDataTable('#table-1')) {
        $('#table-1').DataTable().destroy();
    }
    $('#table-1').DataTable({
        "order": [[0, 'desc']]
    });
});
</script>
<script>
function showOrderDetails(orderId) {
    console.log("Button clicked for order ID:", orderId); // Debugging message
    $.ajax({
        url: `/admin/orders/${orderId}`,
        method: 'GET',
        beforeSend: function() {
            $('#orderDetailModal').modal('show');
            $('#paymentSlip').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
        },
        success: function(response) {
            console.log("AJAX response:", response); // Check response in console

            // Set order details
            $('#orderId').text(response.order.id);
            $('#userName').text(response.order.user?.name || 'N/A');
            $('#courseName').text(response.order.course?.name || 'N/A');
            $('#orderDate').text(new Date(response.order.created_at).toLocaleDateString());
            $('#paymentStatus').val(response.order.status || 'pending');

            // Handle payment slip
            const $paymentSlip = $('#paymentSlip');
            $paymentSlip.empty();

            if (response.paymentSlipUrl) {
                $paymentSlip.html(`
                    <div class="text-center">
                        <img src="${response.paymentSlipUrl}" class="img-fluid" style="max-height: 400px;">
                    </div>
                `);
            } else {
                $paymentSlip.html('<div class="alert alert-info text-center">No payment slip uploaded</div>');
            }
        },
        error: function(xhr) {
            let errorMsg = 'Failed to load order details';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMsg = xhr.responseJSON.error;
            }
            $('#paymentSlip').html(`<div class="alert alert-danger">${errorMsg}</div>`);
            console.error('Error:', xhr.responseText);
        }
    });
}

function updatePaymentStatus() {
  const orderId = $('#orderId').text();
  const status = $('#paymentStatus').val();

  $.ajax({
    url: `/admin/orders/${orderId}`,
    method: 'PUT',
    data: {
      payment_status: status,
      _token: '{{ csrf_token() }}'
    },
    beforeSend: function() {
      $('button').prop('disabled', true);
    },
    success: function(response) {
      if (response.success) {
        $('#orderDetailModal').modal('hide');
        location.reload();
      }
    },
    error: function(xhr) {
      alert('Failed to update status. Please try again.');
      console.error(xhr.responseText);
    },
    complete: function() {
      $('button').prop('disabled', false);
    }
  });
}
</script>
@endpush
