<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{asset('img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">

    <span class="brand-text font-weight-light">AdminLMS - Cowell</span>

  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">

        <a href="#" class="d-block">{{isset(Sentinel::getUser()['first_name'])?Sentinel::getUser()['first_name']:''}}</a>

      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->

        <li class="nav-item menu-open">

        <li class="nav-item">
          <a href="{{route('dashboard')}}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>


        <li class="nav-item">
          <a href="@if(Sentinel::getUser()->inRole('admin')) {{route('users.index')}} @endif" class="nav-link @if(!Sentinel::getUser()->inRole('admin')) disabled @endif">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Users
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="@if( Sentinel::getUser()->inRole('admin') || Sentinel::getUser()->inRole('manager') ) {{route('roles.index')}} @endif" class="nav-link @if( !Sentinel::getUser()->inRole('admin') & !Sentinel::getUser()->inRole('manager') ) disabled @endif">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>
              Roles
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>
            Student
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
              <a href="{{route('student.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Student</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('group.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Group</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{route('group.index')}}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Groups
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('course.index')}}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Courses
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('chapter.index')}}" class="nav-link">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>
              Chapters
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('lesson.index')}}" class="nav-link">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>
              Lessons
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('test.index')}}" class="nav-link">
          <i class="fa-light fa-text"></i>
            <p>
              Tests
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('question.index')}}" class="nav-link">
          <i class="fa-solid fa-comments-question"></i>
            <p>
              Questions
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('answer.index')}}" class="nav-link">
          <i class="fa-thin fa-voicemail"></i>
            <p>
              Answers
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Charts
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="pages/charts/chartjs.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ChartJS</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/charts/flot.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Flot</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/charts/inline.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inline</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/charts/uplot.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>uPlot</p>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>