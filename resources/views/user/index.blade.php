@extends('layouts.master')

@section('title', 'Users')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/responsive.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/sweetalert.css') }}" rel="stylesheet">
  <style>
    @media print {
      table td:last-child {
        display: none
      }

      table th:last-child {
        display: none
      }
    }
  </style>

@endsection
@section('content')

  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">

      <div class="clearfix"></div>
      <!-- row start -->
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>User<small> All User information.</small></h2>
              <a href="{{ URL::Route('user.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> New User </a>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <h3>Users</h3>

              <table id="datatable-buttons" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Subject/Position</th>
                    <th>Assigned Roles</th>
                    <th>Assign Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                @forelse($users as $user)
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->subject_position }}</td>
                    <td>
                      @foreach ($user->roles as $role)
                        {{ $role->name }}
                      @endforeach

                    </td>

                    <td>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal-{{ $user->id }}">
                        Assign
                      </button>

                      <!-- Modal for Role Edit-->
                      <div class="modal fade" id="myModal-{{ $user->id }}" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">{{ $user->name }} Role edit</h4>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('user.assign_roles', $user->id) }}" method="post" role="form" id="role-form-{{ $user->id }}">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-group col-md-12">
                                  <label for="">Select role/s:</label>
                                  <select name="roles[]" class="form-control" multiple="multiple" style="width:100%!important">
                                    @foreach ($allRoles as $role)
                                      <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                  </select>

                                </div>


                                {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                              </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" onclick="$('#role-form-{{ $user->id }}').submit()">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">edit</a>
                      <a href="{{ route('user.destroy', $user->id) }}" class="btn btn-danger btn-sm">delete</a>
                    </td>
                  </tr>
                @empty
                  <td>no users</td>
                @endforelse
              </table>
            </div>
          </div>
          <!-- row end -->
          <div class="clearfix"></div>

        </div>
      </div>
      <!-- /page content -->

    @endsection

    @section('extrascript')
      <!-- dataTables -->
      <script src="{{ URL::asset('assets/js/jquery.dataTables.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/select2.full.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/dataTables.responsive.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/dataTables.buttons.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/buttons.bootstrap.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/buttons.flash.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/buttons.html5.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/buttons.print.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/jszip.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/pdfmake.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/vfs_fonts.js') }}"></script>
      <script src="{{ URL::asset('assets/js/sweetalert.min.js') }}"></script>

      <script>
        $(document).ready(function() {

          //datatables code
          var handleDataTableButtons = function() {
            if ($("#datatable-buttons").length) {
              $("#datatable-buttons").DataTable({
                responsive: true,
                iDisplayLength: 10,
                dom: "Bfrtip",
                buttons: [{
                    extend: "copy",
                    className: "btn-sm",
                    exportOptions: {
                      columns: [0, 1, 2, 3, 4]
                    }
                  },
                  {
                    extend: "csv",
                    className: "btn-sm",
                    exportOptions: {
                      columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                  },
                  {
                    extend: "excel",
                    className: "btn-sm",
                    exportOptions: {
                      columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                  },
                  {
                    extend: "pdfHtml5",
                    className: "btn-sm",
                    exportOptions: {
                      columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                  },
                  {
                    extend: "print",
                    className: "btn-sm"
                  },
                ],
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
        //delete warning
        $('.deleteForm').submit(function(e) {
          e.preventDefault();
          form = this;
          swal({
            title: "User Deletion!",
            text: 'Are you sure to delete this user?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#cc3f44",
            confirmButtonText: "Yes",
            closeOnConfirm: true,
            html: false
          }, function(isConfirm) {
            if (isConfirm)
              form.submit();
          });
        });

        $(document).ready(function() {
          $('.js-example-basic-multiple').select2();
        });
      </script>
    @endsection
