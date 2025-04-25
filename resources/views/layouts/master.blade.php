<!-- <!DOCTYPE html> -->
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/main_logo.png') }}">
  <title>{{ env('APP_NAME') }}</title>
  <!-- Bootstrap -->
  <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ URL::asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/nprogress.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/pnotify.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/pnotify.buttons.css') }}" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="{{ URL::asset('assets/css/custom.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('assets/css/app.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
  @toastr_css
  @yield('extrastyle')
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>

<body class="nav-md footer_fixed">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col menu_fixed">
        <div class="left_col scroll-view">
          <div class="navbar nav_title nav-inverse" style="border: 0;">
            <a href="{{ route('admin.home') }}" class="site_title"> <img src="{{ asset('images/wacheseh_logo.png') }}" alt="admin-login-image" height="50" width="80"> <br></a>
          </div>
          <div class="clearfix"></div>
          <br />
          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu ">
            <div class="menu_section">
              <h3>Primary Menu</h3>
              <ul class="nav side-menu">
                <li>
                  <a href="https://wachesehacademy.com" target="_blank"><i class="fa fa-university" aria-hidden="true"></i>Wacheseh Academy</a>
                </li>
                <li>
                  <a>
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    Settings<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{ route('academicYear.list') }}">Academic Years</a></li>
                    @permission('manage-classes')
                      <li><a href="{{ route('department.index') }}">Classes</a></li>
                    @endpermission

                    @permission('manage-classes')
                      <li><a href="{{ route('user.index') }}">Users </a></li>
                    @endpermission

                    @role('super-admin')
                      <li><a href="{{ route('role.index') }}">Roles </a></li>
                      <li><a href="{{ route('permission.index') }}">Permissions </a></li>
                    @endrole

                    @permission('view-log')
                      <li><a href="{{ route('activity.audit') }}">Activity Log</a></li>
                      <li><a href="{{ route('database.backup') }}">DB Backup</a></li>
                    @endpermission

                  </ul>
                </li>
                {{-- Send Mails --}}
                <li>
                  <a>
                    <i class="fa fa-info-circle    "></i>&nbsp;Student Notifications
                    <span class="fa fa-chevron-down"></span>
                  </a>
                  <ul class="nav child_menu">
                    @permission('send-student-notification')
                      <li><a href="{{ route('notification.send.index') }}"> Send Notifications</a></li>
                    @endpermission

                      @permission('view-sent-notification')
                      <li>
                        <a href="{{ route('notification.list') }}"> Sent Notifications</a>
                      <li>
                      @endpermission

                      @permission('send-email')
                      <li>
                        <a href="{{ route('send.mail.index') }}">Send Emails</a>
                      </li>
                      <li>
                        <a href="{{ route('send.sms.index') }}">Send SMS</a>
                      </li>
                    @endpermission
                  </ul>
                </li>
              {{-- Students --}}
              <li>
                <a><i class="fa fa-users"></i> Student Module <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  @permission('import-students')
                    <li><a href="{{ route('student.excelImport') }}">Import Students</a></li>
                  @endpermission

                  @permission('add-student-profile')
                    <li><a href="{{ route('studentInfo.create') }}">Add New Student</a></li>
                  @endpermission

                  <li><a href="{{ route('studentInfo.index') }}">ALL Students</a></li>
                  <li><a href="{{ route('student.promote.start') }}">Promote Students</a></li>
                </ul>
              </li>

              {{-- Courses --}}
              <li>
                <a><i class="fa fa-book"></i> Subjects & Exams <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li><a href="{{ route('course.index') }}">Subjects</a></li>
                  @permission('manage-classes')
                    <li><a href="{{ route('programs.outline') }}">Program Outline</a></li>
                  @endpermission
                  <li><a href="{{ route('exams.index') }}">Exams</a></li>
                </ul>
              </li>
              {{-- Marks Module --}}
              <li>
                <a><i class="fa fa-book"></i> Marks Module<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  @permission('add-marks')
                    <li><a href="{{ route('mark.import.index') }}">Import Marks</a></li>
                    <li><a href="{{ route('mark.create') }}">Add New Marks</a></li>
                    <li><a href="{{ route('additional_data.index') }}">Add Additional Data</a></li>
                    @endpermission
                </ul>
              </li>
              {{-- Academic Reports --}}
              <li>
                <a><i class="fa fa-file-pdf-o"></i>Academic Reports<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  @permission('add-marks')
                    <li><a href="{{ route('student-marks.index') }}">Individual Student Marks </a></li>
                    <li><a href="{{ route('academic.report-card.index') }}">Generate Report Card</a></li>
                  @endpermission
                </ul>
              </li>

              {{-- Finance Module --}}
              <li>
                <a><i class="fa fa-money"></i> Finance <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  @permission('take-payment')
                    <li>
                      <a href="{{ route('fee.manual.index') }}">Take Payment</a>
                    </li>
                  @endpermission

                  @permission('view-payment-history')
                    <li>
                      <a href="{{ route('fee.payment.today') }}">Payment History</a>
                    </li>
                  @endpermission

                  @permission('set-up-fees')
                    <li>
                      <a href="{{ route('fee.index') }}">Fee-Setup</a>
                    </li>
                  @endpermission
                </ul>
              </li>
              {{-- necessary documents --}}
              @permission('add-document')
                <li>
                  <a href="{{ route('document.index') }}"><i class="fa fa-file-archive"> </i>Documents</a>
                </li>
              @endpermission
              {{-- Teachers --}}
              @permission('add-document')
                <li>
                  <a href="{{ route('teacher.list') }}"><i class="fa fa-user"> </i>Teachers</a>
                </li>
              @endpermission

              {{-- Admin Notes --}}
              <li>
                <a href="{{ route('admin.note.index') }}"><i class="fa fa-comment"></i> Admin Notes</a>
              </li>

              @permission('manage-events')
                <li><a href="{{ route('event-types.index') }}"><i class="fa fa-calendar"></i>Events</a></li>
              @endpermission

              @permission('manage-sessions')
                <li><a href="{{ route('current-semester-running.index') }}"><i class="fa fa-codepen"></i> Sessions</a></li>
              @endpermission
              {{-- Teacher's --}}
              @permission('teacher-courses')
                <li>
                  <a href="{{ route('teacher.courses') }}"><i class="fa fa-book" aria-hidden="true"></i> My Courses</a>
                </li>
              @endpermission

              @permission('teacher-students')
                <li>
                  <a href="{{ route('teacher.students') }}"><i class="fa fa-users" aria-hidden="true"></i> My Students</a>
                </li>
              @endpermission
              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->
        </div>
      </div>
      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i style="color:#f7c115;" class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
              <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();" style="color:white"><i
                    class="glyphicon glyphicon-off"></i> Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
              <li>
                <a href="{{ route('user.settings') }}" style="color:white"> <i class="fa fa-user-circle" aria-hidden="true"></i> {{ auth()->user()->name }}</a>
              </li>
              <li style="float:left;">
                <h1 id="clock" style="color:#fcfcfc;"></h1>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->
    </div>
    <!--Child Page Content Start  -->

    @yield('content')

    <!--Child Page Content End  -->

    @include('layouts.footer')
  </div>
  <!-- jQuery -->
  <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
  <!-- Bootstrap -->
  <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ URL::asset('assets/js/fastclick.js') }}"></script>
  <!-- NProgress -->
  <script src="{{ URL::asset('assets/js/nprogress.js') }}"></script>

  <script src="{{ URL::asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>

  <script src="{{ URL::asset('assets/js/pnotify.js') }}"></script>
  <script src="{{ URL::asset('assets/js/pnotify.buttons.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
  @toastr_js
  @toastr_render
  @yield('extrascript')
  <!-- Custom Theme Scripts -->
  <script src="{{ URL::asset('assets/js/custom.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/app.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

  <script>
    var myVar = setInterval(function() {
      myTimer();
    }, 1000);

    function myTimer() {
      var d = new Date();
      document.getElementById("clock").innerHTML = d.toLocaleTimeString();
    }
  </script>
</body>

</html>
