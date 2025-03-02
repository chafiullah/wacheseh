@extends('layouts.master')

@section('title', 'Payment History')

@section('extrastyle')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            <div class="x_content">
              <h4 class="text-center"><u><b>Search By Date</b></u></h4>
              <form action="{{ route('fee.payment.date') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="">Select Start Date:</label>
                    <input type="date" name="startDate" class="form-control" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Select End Date:</label>
                    <input type="date" name="endDate" class="form-control" required>
                  </div>
                  <div class="form-group col-md-12 col-sm-12">
                    <label for="">List Type:</label>
                    <select name="type" class="form-control">
                      <option value="paid">List of made payments</option>
                      <option value="unpaid">List of students who did not pay any amount within this date range</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-success btn-md pull-right">generate list</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="x_panel">
            <div class="x_content">
                <div class="col-md-12 table-responsive">
                  @if($payments->count() > 0)
                    <h4 class="text-info text-center"><b>Payments on {{ Carbon::today()->format('d M Y') }}</b></h4>
                    <table class="table table-striped datatable">
                      <thead>
                      <th>#</th>
                      <th>Student ID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Paid For</th>
                      <th>Payment Date</th>
                      <th>Status</th>
                      <th>Amount</th>
                      <th>Action</th>
                      </thead>
                      <tbody>
                      @foreach ($payments as $item)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $item->student->student_id }}</td>
                          <td>{{ $item->student->first_name }}</td>
                          <td>{{ $item->student->last_name }}</td>
                          <td>{{ $item->student->email }}</td>
                          <td>{{ $item->student->phone }}</td>
                          <td>{{ $item->paymentTitle->feeTitle }}</td>
                          <td>{{ Carbon::parse($item->created_at)->format('m/d/Y h:i') }}</td>
                          <td>
                            @if ($item->responseCode == '1')
                              <span class="text-success">Approved</span>
                            @elseif ($item->responseCode == '2')
                              <span class="text-danger">Declined</span>
                            @elseif ($item->responseCode == '3')
                              <span class="text-danger">Error</span>
                            @elseif ($item->responseCode == '4')
                              <span class="text-warning">Held for review</span>
                            @elseif ($item->responseCode == null)
                              <span class="text-warning">Held for review</span>
                            @else
                              <span class="text-danger">Unknown Transaction Error with response code: {{ $item->responseCode }}</span>
                            @endif
                          </td>
                          <td>{{ $item->amount }}</td>
                          <td>
                            @if ($item->cardName == 'cash' || $item->cardName == 'cheque' || $item->cardName == 'transfer' || $item->cardName == 'other')
                              <a href="{{ route('fee.manual.edit', $item->id) }}" class="btn btn-warning btn-md" data-toggle="tooltip" data-placement="top" title="edit"><i
                                        class="fas fa-edit    "></i></a>
                              <a href="{{ route('fee.manual.destroy', $item->id) }}" class="btn btn-danger btn-md" data-toggle="tooltip" data-placement="top" title="remove-transaction"
                                 onclick="return confirm('Deleting this entry may affect your financial calculation. Do you still want to continue?')"><i class="fas fa-trash    "></i></a>
                            @endif

                            @if ($item->responseCode == '4')
                              <a href="{{ route('fee.manual.approve', $item->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="give-approval"
                                 onclick="return confirm('Give approval only if you are confirm that the money went through in authorize.net! Once you approve it, this transaction will be reflected as a SUCCESSFUL transaction in both admin and student portal.')"><i
                                        class="fas fa-check"></i></a>

                              <a href="{{ route('fee.manual.reject', $item->id) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="reject-payment"
                                 onclick="return confirm('Reject this payment if you are confirm that the money did not went through in authorize.net! Once you reject it, this transaction will be reflected as a Declined transaction in both admin and student portal.')"><i
                                        class="fas fa-times"></i></a>
                            @endif
                            @if ($item->student->remarks != null)
                              <a href="javascript:void(0)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Student Remarks: {{ $item->student->remarks }}"><i
                                        class="fas fa-comments    "></i></a>
                            @endif
                            @if ($item->note != null)
                              <a href="javascript:void(0)" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Payment Note: {{ $item->note }}"><i
                                        class="fas fa-comments    "></i></a>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                      <tfoot>
                      <tr>
                        <th colspan="9" style="text-align:right">Total:</th>
                        <th colspan="2"></th>
                      </tr>
                      </tfoot>
                    </table>
                  @else
                    <h4 class="text-info text-center"><b>No Payments Today</b></h4>
                  @endif
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extrascript')
  <!-- dataTables -->
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js
                            "></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js
                            "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js
                            "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap.min.js
                            "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
                            "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
                            "></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
                            "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js
                            "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js
                            "></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js
                            "></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>

  @if ($payments != null)
    <script>
      $(document).ready(function() {
        var table = $('.datatable').DataTable({
          dom: 'Bfrtip',
          pageLength: 10,
          buttons: [{
              extend: 'excel',
              className: 'btn btn-primary',
              text: 'Export to Excel'
            },
            {
              extend: 'pdf',
              className: 'btn btn-success',
              text: 'Export to PDF'
            },
          ],
          "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
              data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
              return typeof i === 'string' ?
                i.replace(/[\$,]/g, '') * 1 :
                typeof i === 'number' ?
                i : 0;
            };

            // Total over all pages
            total = api
              .column(9)
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Total over this page
            pageTotal = api
              .column(9, {
                page: 'current'
              })
              .data()
              .reduce(function(a, b) {
                return intVal(a) + intVal(b);
              }, 0);

            // Update footer
            $(api.column(9).footer()).html(
              'FCFA ' + pageTotal
            );
          }
        });
        table.buttons().container()
          .appendTo($('.col-sm-6:eq(0)', table.table().container()));
      });
    </script>
  @endif
@endsection
