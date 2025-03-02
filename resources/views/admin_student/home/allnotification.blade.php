@extends('admin_student.master')

@section('title')
Student || Dashboard
@endsection

@section('main')
    <div class="row mt-3">
        {{-- Student Notifications --}}
        <div class="col-md-12 mt-3">
          @if (count($notifications) > 0)
            @foreach ($notifications as $item)
              <div class="alert alert-info">
                <a href="javascript:void(0)" data-toggle="collapse" data-target="{{ '#notifications'.$item->id }}" aria-expanded="false" aria-controls="{{ '#notifications'.$item->id }}">
                    <i class="fas fa-check-circle    "></i>
                    <u>
                        <b> {{ $item->subject }} - {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                        </b>
                    </u>
                </a>
                <div class="collapse mt-3 ml-5 text-dark" id="{{ 'notifications'.$item->id }}">
                  {!! htmlspecialchars_decode(nl2br($item->notification)) !!}
                </div>
              </div>
            @endforeach
          @else
            <h4 class="text-center my-3"><i class="fas fa-bell-slash    "></i> You have no notifications!</h4>
          @endif
        </div>
    </div>
@endsection