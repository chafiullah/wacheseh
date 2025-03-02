<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ env('APP_NAME') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('/images/main_logo.png') }}" type="image/x-icon">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('admin_student/plugins/select2/select2.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin_student/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  @toastr_css
  @yield('extrastyles')
</head>

<body class="hold-transition sidebar-mini">

  <div class="wrapper">
    {{-- nav bar for mobile view --}}
    @include('admin_student.mobile')
    {{-- mobile view nav bar ends here --}}

    <!-- Top Nav -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
      <ul class="navbar-nav">
        <li class="nav-item">
          <h3 class="card-title">Student Dashboard</h3>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user text-success"></i> Profile
            <span class="badge badge-danger navbar-badge"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="{{ asset(config('constant.asset_url') . 'student_images/' . auth()->user()->image) }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    {{ auth()->user()->first_name }}
                    <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                  </h3>
                  <p class="text-sm text-muted">{{ auth()->user()->last_name }}</p>

                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <p class="text-center my-2">
              <a href="{{ URL::to('/profile-settings') }}" class="text-secondary"> <i class="fas fa-gear"></i>
                Profile Settings</a>
            </p>
            <div class="dropdown-divider"></div>
            <p class="text-center my-2">
              <a href="{{ route('notification.student.all', auth()->user()->id) }}" class="text-secondary"> <i class="fas fa-bell    "></i> All Notifications</a>
            </p>
            <div class="dropdown-divider"></div>
            <p class="text-center my-2"><a href="{{ URL::to('/student-logout') }}" class="btn btn-md btn-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout</a></p>
          </div>
        </li>
        <!-- Notifications Dropdown Menu -->

        {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fa fa-th-large"></i>
        </a>
      </li> --}}
      </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ URL::to('/student-home') }}" class="brand-link">
        <img src="{{ asset('/images/wacheseh_logo.png') }}" alt="Wacheseh Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light" style="font-size:18px">{{ env('APP_NAME') }}</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset(config('constant.asset_url') . 'student_images/' . auth()->user()->image) }}" class="img-circle elevation-2" alt="User Image">
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            {{-- @if ($studentPofile->status == 1) --}}
            <li class="nav-item has-treeview">
              <a href="https://wachesehacademy.com" target="_blank" class="nav-link">
                <i class="nav-icon fa fa-university"></i>
                <p>
                  Wacheseh Academy
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="{{ URL::to('/student-profile') }}" class="nav-link">
                <i class="nav-icon fa fa-user"></i>
                <p>
                  {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </p>
              </a>
            </li>
            {{-- @endif --}}
            <li class="nav-item has-treeview">
              <a href="{{ route('program.outline.student') }}" class="nav-link">
                <i class="nav-icon fas fa-book-open"></i>
                <p>Program Outline</p>
              </a>
            </li>
            {{-- @if ($academicResults->status == 1) --}}
            <li class="nav-item has-treeview">
              <a href="{{ route('student.result.index') }}" class="nav-link {{ Request::routeIs('student.show_result') ? 'active' : '' }}"> <i class="nav-icon fas fa-pen"></i> Academic
                Results</a>
            </li>
            <li class="nav-item has-treeview">
              <a href="{{ URL::to('/student-payment') }}" class="nav-link">
                <i class="nav-icon fas fa-money-check-alt"></i>
                <p>
                  Payments
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="{{ route('student.documents') }}" class="nav-link">
                <i class="nav-icon fas fa-file-pdf    "></i>
                <p>Documents</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('main')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer text-center">
      <strong>Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') }} <a href="#"> {{ env('APP_NAME') }} </a></strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset("admin_student/plugins/jquery/jquery.min.js") }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <!-- toastr -->
  @toastr_js
  @toastr_render
  <!-- Bootstrap 4 -->
  <script src="{{ asset('admin_student/plugins/bootstrap/js/bootstrap.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('admin_student/plugins/select2/select2.full.min.js') }}"></script>
  <!-- SlimScroll -->
  <script src="{{ asset('admin_student/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('admin_student/plugins/fastclick/fastclick.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('admin_student/dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('admin_student/dist/js/demo.js') }}"></script>
  @yield('extrascript')
  <script>
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()
    })
  </script>

</body>

</html>
