@extends('layouts.master')

@section('title', 'Users Action-Role')
@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/responsive.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
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
              <h3>Roles</h3>
              <a class="btn btn-success pull-right" href="{{ route('role.create') }}"> <i class="fa fa-plus"></i> Create Role</a>
              <table class="table">
                <tr>
                  <th>Name</th>
                  <th>Display Name</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>

                @forelse($roles as $role)
                  <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->display_name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>
                      <a class="btn btn-info btn-sm" href="{{ route('role.edit', $role->id) }}">Edit</a>
                      <form action="{{ route('role.destroy', $role->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input class="btn btn-sm btn-danger" type="submit" value="Delete">
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td>No roles</td>
                  </tr>
                @endforelse

              </table>


              <div class="clearfix"></div>
            </div>

          </div>
          <!-- row end -->
          <div class="clearfix"></div>

        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->
@endsection
@section('extrascript')
  <!-- dataTables -->
  <script src="{{ URL::asset('assets/js/jquery.dataTables.min.js') }}"></script>
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

  <script>
    $(document).ready(function() {

      //datatables code
      var handleDataTableButtons = function() {
        if ($("#datatable-buttons").length) {
          $("#datatable-buttons").DataTable({
            responsive: true,
            dom: "Bfrtip",
            buttons: [{
                extend: "copy",
                className: "btn-sm"
              },
              {
                extend: "csv",
                className: "btn-sm"
              },
              {
                extend: "excel",
                className: "btn-sm"
              },
              {
                extend: "pdfHtml5",
                className: "btn-sm"
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
  </script>
  <!-- /validator -->
@endsection
