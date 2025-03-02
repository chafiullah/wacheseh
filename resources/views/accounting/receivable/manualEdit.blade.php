@extends('layouts.master')

@section('title', 'Finance')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            <div class="x_content">
              <form action="{{ route('fee.manual.update', $payment->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="">Student ID:</label>
                    <select name="studentID" class="form-control" autocomplete="off" required>
                      @foreach ($students as $student)
                        <option value="{{ $student->id }}" @if ($payment->studentID == $student->id) selected @endif>
                          {{ $student->student_id . ' - ' . $student->first_name . ' - ' . $student->last_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="">Payment Type:</label>
                    <select name="paidFor" class="form-control" id="paidFor" required>
                      @foreach ($feeTypes as $item)
                        <option value="{{ $item->id }}" @if ($payment->paidFor == $item->id) selected @endif>{{ $item->feeTitle }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="">Payable Amount: (Minimum Payable is selected)</label>
                    <input type="number" id="minimumPayable" class="form-control" name="amount" value="{{ $payment->amount }}" required>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="">Payment Method:</label>
                    <select name="paymentMethod" class="form-control" id="paymentMethod" required>
                      <option value="cash" @if ($payment->paid_by == 'cash') selected @endif>Cash</option>
                      <option value="cheque" @if ($payment->paid_by == 'cheque') selected @endif>Cheque</option>
                      <option value="momo_transfer" @if ($payment->paid_by == 'momo_transfer') selected @endif>MoMo Transfer</option>
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="">Note: [If have any, otherwise keep it blank]</label>
                    <input type="text" class="form-control" name="note" value="{{ $payment->note }}">
                  </div>
                  <div class="form-group col-md-12">
                    <button class="btn btn-success pull-right" type="submit">update</button>
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
  <script src="{{ URL::asset('assets/js/select2.full.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      $(".select2").select2({
        allowClear: true
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $("#paidFor").on("change", function() {
        var itemID = $("#paidFor").val();
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
            $("#minimumPayable").attr({
              "value": response,
              "min": response
            });
            // console.log(response);
          }
        });
      });
    });
  </script>
@endsection
