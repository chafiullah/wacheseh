@extends('layouts.master')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            {{-- department wise students --}}
            <div class="x_title">
              <h2>Students<small> All Students information.</small></h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content table-responsive">
              <form action="{{ route('send.sms.send') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="">Select Student/s:</label>
                    <select class="form-control" id="studentType" name="studentType" required>
                      <option value="" selected disabled>choose recipients..</option>
                      <option value="specific">select specific students</option>
                      <option value="active">select active students</option>
                      <option value="alumni">select alumni students</option>
                    </select>
                  </div>
                  <div class="form-group col-md-12" id="specificStudents" style="display:none;">
                    <label for="">Select Student/s:</label>
                    <select name="studentIDs[]" class="form-control select2" multiple>
                      <option></option>
                      @foreach ($students as $item)
                        <option value="{{ $item->id }}">{{ $item->student_id . ' - ' . $item->first_name . ' - ' . $item->last_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="">Body: <span class="text-info">[160 characters will be counted a single SMS.]</span></label>
                    <textarea cols="5" rows="5" name="body" class="form-control" onkeyup="countTotalCharacters(this)"></textarea>
                    <small id="charactersCount" class="text-danger"></small>
                  </div>
                  <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success pull-right"><i class="fas fa-envelope"></i> send sms</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="x_panel">
            {{-- department wise students --}}
            <div class="x_title">
              <h2>Reporting of Last 7 Days</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <table id="datatable-buttons" class="table table-striped">
                <thead>
                <tr>
                  <th>Sid</th>
                  <th>Cost</th>
                  <th>Recipient</th>
                  <th>Message Body</th>
                  <th>Sent on</th>
                  <th>Delivery Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($messages as $message)
                  @php
                      $client = new \Twilio\Rest\Client(config('constant.twilio_sid'), config('constant.twilio_token'));
                      $twilio_response = $client->messages($message->sid)->fetch();
                      $message->update([
                        'cost'=>$twilio_response->price
                      ]);
                  @endphp
                  <tr>
                    <td>{{$message->sid}}</td>
                    <td>{{$message->cost}}</td>
                    <td>{{$message->recipient}}</td>
                    <td>{{$message->body}}</td>
                    <td>{{Carbon::parse($message->created_at)->format('d M Y h:s')}}</td>
                    <td>
                      @if($twilio_response->status == 'delivered')
                        <span class="btn btn-success btn-sm">{{$twilio_response->status}}</span>
                      @else
                        <span class="btn btn-danger btn-sm">{{$twilio_response->status}}</span>
                      @endif
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
  <!-- /page content -->
@endsection

@section('extrascript')
  <script src="{{ URL::asset('assets/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.flash.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.html5.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.print.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/pdfmake.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/vfs_fonts.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.select2').select2({
        placeholder: 'select student/s',
        allowClear: true
      });
      $("#studentType").on('change', function() {
        var studentType = $("#studentType").val();
        if (studentType == 'specific') {
          $('#specificStudents').css('display', 'block');
        } else {
          $('#specificStudents').css('display', 'none');
        }
      });
      //datatables code
      var handleDataTableButtons = function() {
        if ($("#datatable-buttons").length) {
          $("#datatable-buttons").DataTable({
            responsive: true,
            dom: "Bfrtip",
            buttons: [{
              extend: "excel",
              className: "btn-sm"
            }, ],
            responsive: true
          });
        }
      };

      TableManageButtons = function() {
        "use strict";
        return {
          init: function() {
            handleDataTableButtons();
          }
        };
      }();

      TableManageButtons.init();

    });
  </script>
  <script>
    function countTotalCharacters(textAreaObject){
      const totalCharacters = textAreaObject.value.length;
      $("#charactersCount").text('Total Characters: '+totalCharacters);
    }
  </script>
@endsection
