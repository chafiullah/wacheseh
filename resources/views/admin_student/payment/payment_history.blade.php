@extends('admin_student.master')


@section('extrastyles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endsection

@section('main')
  <div class="row .mt-3">
    <div class="col-md-12 mt-3">
      <div class="card">
        <div class="card-body">
          <table class="table table-striped dataTable">
            <thead>
              <th>Paid For</th>
              <th>Amount</th>
              <th>Date</th>
              <th>Status</th>
            </thead>

            <tbody>
              @foreach ($payments as $item)
                <tr>
                  <td>{{ $item->paymentTitle->feeTitle }}</td>
                  <td>{{ number_format((float) ($amount = $item->amount), 2, '.', '') }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('m/d/Y h:m') }}</td>
                  @if ($item->responseCode == '1')
                    <td><i class="fas fa-check text-success"></i> Approved</td>
                  @elseif ($item->responseCode == '2')
                    <td><i class="fas fa-times text-danger"></i> Declined</td>
                  @elseif ($item->responseCode == '3')
                    <td><i class="fas fa-times text-danger"></i> Error</td>
                  @elseif ($item->responseCode == '4')
                    <td><i class="fas fa-pause text-warning"></i> Held for confirmation</td>
                  @else
                    <td><i class="fas fa-check text-info"></i>Payment Responded with code: {{ $item->responseCode }}, please contact with the admin.</td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extrascript')
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js
            "></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
            "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
            "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js
            "></script>
  <script>
    $(document).ready(function() {
      $('.dataTable').DataTable({
        dom: 'Bfrtip',
        buttons: [{
          extend: 'pdfHtml5',
          messageTop: 'Payment History of ' + '{{ $student->first_name }} ' + '{{ $student->last_name }} ' + ', ID: {{ $student->student_id }}',
          text: 'Download as PDF',
          className: 'btn btn-success btn-md'
        }]
      });
    });
  </script>
@endsection
