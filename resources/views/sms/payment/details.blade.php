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
              <form action="{{route('sent.sms.calculator')}}" method="POST">
              @csrf
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="">From:</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" required/>
                  </div>
                   <div class="form-group col-md-6">
                    <label for="">From:</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" required/>
                  </div>
                  <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success pull-right"><i class="fas fa-dollar-sign"></i> calculate</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        @if(Request::routeIs('sent.sms.calculator'))
            <div class="col-md-12">
                <div class="x_panel">
                    {{-- department wise students --}}
                    <div class="x_title">
                    <h2>Reporting:</h2>
                    <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <h4>Total SMS Sent: <b>{{ $messages->count() }}</b></h4>
                        <h4>Total Spent: <b>$ {{ $messages->sum('cost')*-1 }}</b></h4>
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
        @endif
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
@endsection
