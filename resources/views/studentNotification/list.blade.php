@extends('layouts.master')

@section('title', 'Custom Notifications')

@section('extrastyle')
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
                <div class="x_content">
                  <i class="fas fa-info-circle    "></i> - Student Did not Read the Notification Yet! <br>
                  <i class="fas fa-check-circle    "></i> - Student Read the Notification.
                </div>
               </div>
             </div>
             @foreach ($notifications as $item)
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_content">
                    <a href="javascript:void(0)" data-toggle="collapse" data-target="{{ '#notification'.$item->id }}">
                      <h4 class="text-info">
                        @if ($item->status == 2)
                          <i class="fas fa-check-circle    "></i>
                        @else
                          <i class="fas fa-info-circle    "></i>
                        @endif 
                        <u><b>{{ $item->subject }} - Sent to {{ $item->studentID }}</b></u> - {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</h4>
                    </a>
                    <div id="{{ 'notification'.$item->id }}" class="collapse" style="font-size: 16px;color:black;margin-left:20px;">
                      {!! htmlspecialchars_decode(nl2br($item->notification)) !!}
                    </div>
                  </div>
                </div>
              </div>
             @endforeach
           </div>
         </div>
        </div>
        <!-- /page content -->
@endsection

