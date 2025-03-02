@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <!-- /top tiles -->
      <div class="row tile_count text-center">
        <div class="col-md-12">
          @foreach ($unReadNotes as $item)
            <a href="javascript:void(0)" data-toggle="collapse" data-target="{{ '#note' . $item->id }}">
              <h4 class="text-info">
                <i class="fas fa-info-circle    "></i>
                <u><b>{{ $item->subject }} - from {{ $item->user->name }}</b></u> - {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
              </h4>
            </a>
            <div id="{{ 'note' . $item->id }}" class="collapse" style="font-size: 16px;color:black;margin-left:20px;">
              {{ $item->note }}
            </div>
          @endforeach
          @if (count($unReadNotes) > 0)
            <a href="{{ route('admin.note.clear') }}" class="btn btn-success pull-right"><i class="fas fa-eraser    "></i> clear all notes</a>
          @endif
        </div>

        <div class="col-md-12 text-center">
          <div class="x_panel">
            <div class="x_content">
              <img src="{{ asset('images/main_logo.png') }}" height="100" width="100" alt="logo">
              <h4 class="text-center text-success mt-5">{{ env('APP_NAME') }}</h4>
              <h2 class="text-center text-success mt-5">Active Academic Year: <b>{{Helper::getActiveAcademicYear()->alias}}</b></h2>
            </div>
          </div>
        </div>
        {{-- Active --}}
        <div class="col-md-3 col-sm-12 col-xs-12 tile_stats_count">
          <div class="x_panel">
            <div class="x_content">
              <span class="count_top" style="font-size: 24px"><i class="fa fa-2x fa-users green"></i> Active</span>
              <div class="count blue">
                {{ $active_students }}
              </div>
            </div>
          </div>
        </div>
        {{-- Withdrawn --}}
        <div class="col-md-3 col-sm-12 col-xs-12 tile_stats_count">
          <div class="x_panel">
            <div class="x_content">
              <span class="count_top" style="font-size: 24px"><i class="fa fa-2x fa-users purple"></i> Withdrawn</span>
              <div class="count blue">
                {{ $admittedStudents->where('status', 'Withdrawn')->count() }}
              </div>
            </div>
          </div>
        </div>
        {{-- Expelled --}}
        <div class="col-md-3 col-sm-12 col-xs-12 tile_stats_count">
          <div class="x_panel">
            <div class="x_content">
              <span class="count_top" style="font-size: 24px"><i class="fa fa-2x fa-users red"></i> Expelled</span>
              <div class="count blue">
                {{ $admittedStudents->where('status', 'Expelled')->count() }}
              </div>
            </div>
          </div>
        </div>
        {{-- Alumni --}}
        <div class="col-md-3 col-sm-12 col-xs-12 tile_stats_count">
          <div class="x_panel">
            <div class="x_content">
              <span class="count_top" style="font-size: 24px"><i class="fa fa-2x fa-users blue"></i> Alumni</span>
              <div class="count blue">
                {{ $admittedStudents->where('status', 'Alumni')->count() }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /top tiles -->
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 text-center">
          <div class="x_panel">
            <div class="x_content">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Event</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($academic_calender as $item)
                    <tr>
                      <td>{{ $item->title }}</td>
                      <td>{{ Carbon::parse($item->from)->format('d M Y') }}</td>
                      <td>{{ Carbon::parse($item->to)->format('d M Y') }}</td>
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

@endsection
