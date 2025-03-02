@extends('layouts.master')

@section('title', 'Student Portal Features')


@section('content')
        <!-- page content -->
        <div class="right_col" role="main">
         <div class="">
           <div class="clearfix"></div>
           <div class="row">
             <div class="col-md-12">
              {{-- Student Portal Features --}}
              <div class="x_panel">
                {{-- department wise students --}}
                <div class="x_title">
                  <h4 class="text-info">Student Portal Features</h4>
                  <div class="clearfix"></div>
                </div>
                
                <div class="x_content table-responsive">
                  <table class="table table-striped">
                    <thead>
                        <th>Feature Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        @foreach ($features as $item)
                            <tr>
                                <td>{{ $item->featureName }}</td>
                                <td>
                                    @if ($item->status == 0)
                                        <span class="text-danger">inactive</span>
                                    @else
                                        <span class="text-success">active</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('student.feature.manage',$item->id) }}" class="btn btn-warning btn-md" data-toggle="tooltip" data-placement="top" title="change-status" onclick="return confirm('If you change this status, the features in student portal will act accordingly. Confirm action?')"><i class="fas fa-cog    "></i> </a>
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
