@extends('layouts.master')

@section('title', 'My Students')

@section('extrastyle')
  <link href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.css">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
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
              <h3>My Students</h3>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form action="javascript:void(0)" method="post">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="">Select a course:</label>
                    <select name="course_id" class="form-control select2" id="selected_course">
                      <option></option>
                      @foreach ($course_profile_courses as $item)
                        <option value="{{ $item->course_id }}">{{ $item->course->course_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- row end -->
          <div class="clearfix"></div>
        </div>
        {{-- course groups --}}
        <div class="col-md-12 col-sm-12 col-xs-12" id="course_group_content" style="display: none">
          <div class="x_panel">
            <div class="x_content">
              <div class="row">
                <div class="col-md-3 col-sm-12" id="group_names">

                </div>
                <div class="col-md-9 col-sm-12" id="group_students">

                </div>
              </div>
            </div>
          </div>
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
  <script src="{{ URL::asset('assets/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.flash.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.html5.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/buttons.print.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/pdfmake.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/vfs_fonts.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".select2").select2({
        placeholder: "select courses....."
      });
    });
  </script>
  <script>
    $(document).ready(function() {

      //datatables code
      var handleDataTableButtons = function() {
        if ($("#datatable-buttons").length) {
          $("#datatable-buttons").DataTable({
            responsive: true,
            dom: "Bfrtip",
            "aaSorting": [],
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
  {{-- ajax to fetch course groups --}}
  <script>
    $(document).ready(function() {
      $("#selected_course").on("change", function() {
        var course_id = $("#selected_course").val();
        var path = "{{ route('teacher.course.group.list') }}";
        $.ajax({
          type: "get",
          url: path,
          data: {
            'course_id': course_id
          },
          dataType: "html",
          success: function(response) {
            $("#course_group_content").css('display', 'block');
            $("#group_names").empty();
            $("#group_students").empty();
            $("#group_names").html(response);
          }
        });
      });
    });
  </script>
  {{-- ajax to create group --}}
  <script>
    // create the group
    function create_group() {
      $('#gourp_create_modal').modal('toggle');
      let course_id = $("#selected_course").val();
      let group_name = $("#gourp_name").val();
      let path = "{{ route('teacher.course.group.store') }}";
      $.ajax({
        type: "post",
        url: path,
        data: {
          "_token": "{{ csrf_token() }}",
          'course_id': course_id,
          'group_name': group_name
        },
        dataType: "json",
        success: function(response) {
          if (response === 'success') {
            var course_id = $("#selected_course").val();
            var path = "{{ route('teacher.course.group.list') }}";
            $.ajax({
              type: "get",
              url: path,
              data: {
                'course_id': course_id
              },
              dataType: "html",
              success: function(response) {
                $("#course_group_content").css('display', 'block');
                $("#group_names").empty();
                $("#group_names").html(response);
              }
            });
            Swal.fire({
              icon: 'success',
              title: 'Group created successfully!',
              text: 'Your group has been created successfully!'
            })
          } else {
            $("#gourp_name").val('');
            Swal.fire({
              icon: 'error',
              title: 'Duplicate Group Detected',
              text: 'You already have a group with this name'
            })
          }
        }
      });
    }

    // delete the group
    function delete_group(group_id) {
      let path = "{{ route('teacher.course.group.destroy') }}";
      $.ajax({
        type: "get",
        url: path,
        data: {
          'group_id': group_id
        },
        dataType: "html",
        success: function(response) {
          var course_id = $("#selected_course").val();
          var path = "{{ route('teacher.course.group.list') }}";
          $.ajax({
            type: "get",
            url: path,
            data: {
              'course_id': course_id
            },
            dataType: "html",
            success: function(response) {
              $("#course_group_content").css('display', 'block');
              $("#group_names").empty();
              $("#group_names").html(response);
            }
          });
          Swal.fire({
            icon: 'success',
            title: 'Group deleted successfully!',
            text: 'Your group has been deleted successfully!'
          })
        }
      });
    }

    // list of students
    function get_students(group_id) {
      let path = "{{ route('teacher.course.group.student.list') }}";
      var course_id = $("#selected_course").val();
      $.ajax({
        type: "get",
        url: path,
        data: {
          "group_id": group_id,
          "course_id": course_id
        },
        dataType: "html",
        success: function(response) {
          $("#group_students").empty();
          $("#group_students").html(response);
        }
      });
    }

    // add students to group
    function add_students_to_group() {
      let students = $("#selected_students").val();
      let group_id = $("#group_id").val();
      let path = "{{ route('teacher.course.group.student.store') }}";
      $.ajax({
        type: "post",
        url: path,
        data: {
          "_token": "{{ csrf_token() }}",
          "students": students,
          "group_id": group_id
        },
        dataType: "json",
        success: function(response) {
          if (response === 'success') {
            $("#add_student_modal").modal('toggle');
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Students added to the group successfully!'
            });
            get_students(group_id);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Something went wrong, please contact admin.'
            })
          }
        }
      });
    }
    // remove student from the group
    function delete_group_student(id, group_id) {
      let path = "{{ route('teacher.course.group.student.destroy') }}";
      $.ajax({
        type: "get",
        url: path,
        data: {
          'id': id
        },
        dataType: "json",
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Students removed from the group successfully!'
          });
          get_students(group_id);
        }
      });
    }
  </script>
  <!-- /validator -->
@endsection
