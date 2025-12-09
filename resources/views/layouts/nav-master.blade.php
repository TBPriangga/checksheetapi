<nav class="navbar-default navbar-static-side" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
      <li class="nav-header">
        <div class="dropdown profile-element">
          <img alt="image" class="rounded-circle" src="{{asset('image/user.png')}}"/>
          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <span class="block m-t-xs font-bold">{{auth()->user()->name}}</span>
            <span class="text-muted text-xs block">
              @if (auth()->user()->department != null)
                {{auth()->user()->detail_department->code}} 
                {{auth()->user()->npk}} 
              @endif
            </span>
          </a>
        </div>
        <div class="logo-element">AJI</div>
      </li>
 <!-- navbar item -->
      @auth
      <li class="navbar-item" title="Dashboard Admin">
        <a href="{{ route('ss.dashboardadmin') }}" class="btn btn-no-border btn-block mb-2 d-flex align-items-center">
          <i class="fa fa-tachometer me-2"></i>
          <span class="menu-text">Dashboard</span>
        </a>
      </li>
      <li class="navbar-item" title="Submit SS">
        <a href="{{ route('ss.submitadmin') }}" class="btn btn-no-border btn-block mb-2 d-flex align-items-center">
          <i class="fa fa-upload me-2"></i>
          <span class="menu-text">Submit SS</span>
        </a>
      </li>
      <li class="navbar-item" title="List Data SS">
        <a href="" class="btn btn-no-border btn-block mb-2 d-flex align-items-center">
          <i class="fa fa-building me-2"></i>
          <span class="menu-text">Status Pengajuan</span>
        </a>
      </li>
      <li class="navbar-item" title="Kelola Akun">
        <a href="" class="btn btn-no-border btn-block mb-2 d-flex align-items-center">
          <i class="fa fa-user me-2"></i>
          <span class="menu-text">Kelola Akun</span>
        </a>
      </li>
 <!-- 
      <li class="navbar-item" title="Dashboard SPV">
        <a href="" class="btn btn-no-border btn-block mb-2 d-flex align-items-center">
          <i class="fa fa-tachometer me-2"></i>
          <span class="menu-text">Dashboard SPV</span>
        </a>
      </li>
      <li class="navbar-item" title="Dashboard Dept Head">
        <a href="" class="btn btn-no-border btn-block mb-2 d-flex align-items-center">
          <i class="fa fa-building me-2"></i>
          <span class="menu-text">Dashboard Dept Head</span>
        </a>
      </li>
      <li class="navbar-item" title="Dashboard Standarisasi">
        <a href="" class="btn btn-no-border btn-block mb-2 d-flex align-items-center">
          <i class="fa fa-check-circle me-2"></i>
          <span class="menu-text">Dashboard Standarisasi</span>
        </a>
      </li> -->
      @endauth 

    </ul>
  </div>
</nav>