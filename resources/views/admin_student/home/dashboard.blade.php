@extends('admin_student.master')

@section('extrastyles')
  <style>
    .tile_stats_count {
      text-align: center;
    }

    .count {
      font-size: 48px;
      font-weight: bold;
    }

    .purple {
      color: #9b59b6;
    }
  </style>
@endsection

@section('main')
  <div class="row mt-3">
    <div class="col-md-12">
      @if (Hash::check('student#', auth()->user()->password))
        <div class="alert alert-danger">
          <strong>Danger!</strong> Default password is used to login, we recommend changing your password right now.
        </div>
        <div class="alert alert-info">
          <strong>Steps to change your password :</strong> Profile > Settings > Update Password.
        </div>
      @endif
    </div>
    {{-- Student Notifications --}}
    <div class="col-md-12 mt-3">
      @if (count($notifications) > 0)
        <h4 class="text-center my-3"><i class="fas fa-bell text-info"></i> You have <b>{{ count($notifications) }}</b> unread notifications!</h4>
        @foreach ($notifications as $item)
          <div class="alert alert-info">
            <a href="javascript:void(0)" data-toggle="collapse" data-target="{{ '#notifications' . $item->id }}" aria-expanded="false" aria-controls="{{ '#notifications' . $item->id }}"><u><b><i
                    class="fas fa-info-circle    "></i> {{ $item->subject }} -
                  {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</b></u></a>
            <div class="collapse mt-3 ml-5 text-dark" id="{{ 'notifications' . $item->id }}">
              {!! htmlspecialchars_decode(nl2br($item->notification)) !!}
            </div>
          </div>
        @endforeach
        <a href="{{ route('notification.mark.read', auth()->user()->id) }}" class="btn btn-success bt-md float-right">Mark All as Read</a>
      @else
        <h4 class="text-center my-3"><i class="fas fa-bell-slash    "></i> You have no unread notifications!</h4>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="card">
        <div class="card-body">
          <img src="{{ asset('assets/images/main_logo.png') }}" height="100" width="100" alt="logo">
          <h4 class="text-center text-success mt-5">{{ env('APP_NAME') }}</h4>
        </div>
      </div>
    </div>
    {{-- Active --}}
    <div class="col-md-3 col-sm-12 col-xs-12 tile_stats_count">
      <div class="card">
        <div class="card-body">
          <span class="text-success" style="font-size: 24px"><i class="fa fa-2x fa-users"></i> Active</span>
          <div class="count text-primary">
            {{ $admittedStudents->where('status', 'Active')->count() }}
          </div>
        </div>
      </div>
    </div>
    {{-- Withdrawn --}}
    <div class="col-md-3 col-sm-12 col-xs-12 tile_stats_count">
      <div class="card">
        <div class="card-body">
          <span class="purple" style="font-size: 24px"><i class="fa fa-2x fa-users"></i> Withdrawn</span>
          <div class="count blue">
            {{ $admittedStudents->where('status', 'Withdrawn')->count() }}
          </div>
        </div>
      </div>
    </div>
    {{-- Expelled --}}
    <div class="col-md-3 col-sm-12 col-xs-12 tile_stats_count">
      <div class="card">
        <div class="card-body">
          <span class="text-danger" style="font-size: 24px"><i class="fa fa-2x fa-users"></i> Expelled</span>
          <div class="count blue">
            {{ $admittedStudents->where('status', 'Expelled')->count() }}
          </div>
        </div>
      </div>
    </div>
    {{-- Alumni --}}
    <div class="col-md-3 col-sm-12 col-xs-12 tile_stats_count">
      <div class="card">
        <div class="card-body">
          <span class="text-primary" style="font-size: 24px"><i class="fa fa-2x fa-users"></i> Alumni</span>
          <div class="count blue">
            {{ $admittedStudents->where('status', 'Alumni')->count() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="card">
        <div class="card-body">
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
@endsection
