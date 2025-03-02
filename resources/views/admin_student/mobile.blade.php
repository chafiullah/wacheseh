<nav class="navbar navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
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
  </div>
</nav>
