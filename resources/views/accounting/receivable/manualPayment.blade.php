@extends('layouts.master')

@section('extrastyle')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 mt-3">
          <div class="x_panel">
            <div class="x_content">
              @if (session('success_msg'))
                <div class="alert alert-success fade in alert-dismissible show">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="font-size:20px">×</span>
                  </button>
                  {{ session('success_msg') }}
                </div>
              @endif
              @if (session('error_msg'))
                <div class="alert alert-danger fade in alert-dismissible show">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="font-size:20px">×</span>
                  </button>
                  {{ session('error_msg') }}
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item active">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Card Payment</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Pay by Others</a>
        </li>
      </ul>

      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade active in" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="x_panel">
            <div class="x_content">
              <h4 class="text-center"><u><b>Take Payment Through Card</b></u></h4>
              <form action="{{ route('fee.manual.store') }}" method="post" enctype="multipart/form-data" data-cc-on-file="false" data-stripe-publishable-key="{{ config('constant.stripe_key') }}"
                id="payment-form">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="">Student ID: <span class="text-danger">*</span></label>
                    <select name="studentID" class="select2 form-control" required>
                      <option></option>
                      @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->student_id . ' - ' . $student->first_name . ' ' . $student->last_name . ' CLass - ' . $student->class }}</option>
                      @endforeach
                    </select>
                    {{-- payment method --}}
                    <input type="hidden" name="paymentMethod" value="card">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="">Payment Type: <span class="text-danger">*</span></label>
                    <select name="paidFor" class="form-control" id="cardPaidFor" required>
                      <option value="" selected disabled>please choose...</option>
                      @foreach ($feeTypes as $item)
                        <option value="{{ $item->id }}">{{ $item->feeTitle }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="">Payable Amount: <span class="text-danger">*</span> (Minimum Payable is selected)</label>
                    <input type="number" class="form-control" id="cardPaidForMinimumPayable" name="amount" required>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="">Payment Date:<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="advancePayment" required>
                  </div>
                  <div class="form-group col-md-12" id="paymentNote" style="display: none">
                    <label for="">Note: [If have any, otherwise keep it blank]</label>
                    <input type="text" class="form-control" name="note">
                  </div>
                </div>
                <div class="form-row" id="cardSection">
                  <div class="form-group col-md-6">
                    <label for="">Card Holder:</label>
                    <input type="text" name="cardName" class="form-control" autocomplete='off'>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Card Number:</label>
                    <input type="text" name="cardNumber" class="form-control card-number">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">CVV:</label>
                    <input type="text" name="cvv" class="form-control card-cvc">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Card Expiration:</label>
                    <input type="text" name="expMonth" class="datepicker form-control" id="card-expiry">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <button class="btn btn-success pull-right" type="submit">make payment</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="x_panel">
            <div class="x_content">
              <h4 class="text-center"><u><b>Payment Through Other Options</b></u></h4>
              <form action="{{ route('fee.manual.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="">Student ID: <span class="text-danger">*</span></label>
                    <select name="studentID" class="select2 form-control" required>
                      <option></option>
                      @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->student_id . ' - ' . $student->first_name . ' ' . $student->last_name . ' CLass - ' . $student->class }}</option>
                      @endforeach
                    </select>
                    {{-- payment method --}}
                    <input type="hidden" name="paymentMethod" value="others">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="">Payment Type: <span class="text-danger">*</span></label>
                    <select name="paidFor" class="form-control" id="otherPaidFor" required>
                      <option value="" selected disabled>please choose...</option>
                      @foreach ($feeTypes as $item)
                        <option value="{{ $item->id }}">{{ $item->feeTitle }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="">Payable Amount: <span class="text-danger">*</span> (Minimum Payable is selected)</label>
                    <input type="number" class="form-control" id="otherPaidForMinimumPayable" name="amount" required>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="">Payment Method:<span class="text-danger">*</span></label>
                    <select name="paymentMethod" class="form-control" id="paymentMethod" required="">
                      <option value="bank_receipt">Bank Receipt</option>
                      <option value="momo_transfer">MoMo Transfer</option>
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="">Payment Date:<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="advancePayment" required>
                  </div>
                  <div class="form-group col-md-12" id="paymentNote">
                    <label for="">Note: [If have any, otherwise keep it blank]</label>
                    <input type="text" class="form-control" name="note">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <button class="btn btn-success pull-right" type="submit">make payment</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extrascript')
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
  {{-- others --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="{{ URL::asset('assets/js/select2.full.min.js') }}"></script>
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script>
    $(document).ready(function() {
      var table = $('.datatable').DataTable({
        dom: 'Bfrtip',
        pageLength: 15,
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
          {
            extend: 'colvis',
            columns: ':not(.noVis)',
            className: 'btn btn-info',
            text: 'Column Visibility'
          }
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
        },
      });
      table.buttons().container()
        .appendTo($('.col-sm-6:eq(0)', table.table().container()));
    });
  </script>
  <script>
    $(document).ready(function() {
      $(".select2").select2({
        placeholder: "Select a value",
        allowClear: true
      });
      $('.datepicker').datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months",
        orientation: "top right",
        autoclose: true
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $("#cardPaidFor").on("change", function() {
        var itemID = $("#cardPaidFor").val();
        var path = "{{ route('pay.minimum') }}";
        //  console.log(itemID);
        $.ajax({
          type: "get",
          url: path,
          data: {
            'itemID': itemID
          },
          dataType: "json",
          success: function(response) {
            $("#cardPaidForMinimumPayable").attr({
              "value": response
            });
            // console.log(response);
          }
        });
      });
      // others
      $("#otherPaidFor").on("change", function() {
        var itemID = $("#otherPaidFor").val();
        var path = "{{ route('pay.minimum') }}";
        //  console.log(itemID);
        $.ajax({
          type: "get",
          url: path,
          data: {
            'itemID': itemID
          },
          dataType: "json",
          success: function(response) {
            $("#otherPaidForMinimumPayable").attr({
              "value": response
            });
            // console.log(response);
          }
        });
      });
    });
  </script>

  {{-- stripe payment --}}
  <script>
    $("#payment-form").submit(function(e) {
      const cardExpiry = $("#card-expiry").val().split("-");
      console.log(cardExpiry);
      e.preventDefault();
      Stripe.setPublishableKey($("#payment-form").data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: cardExpiry[0],
        exp_year: cardExpiry[1]
      }, stripeResponseHandler);
    });

    function stripeResponseHandler(status, response) {
      if (response.error) {
        $('.error')
          .removeClass('hide')
          .find('.alert')
          .text(response.error.message);
      } else {
        // token contains id, last4, and card type
        var token = response['id'];
        // insert the token into the form so it gets submitted to the server
        $("#payment-form").find('input[type=text]').empty();
        $("#payment-form").append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
        $("#payment-form").get(0).submit();
      }
    }
  </script>
@endsection
