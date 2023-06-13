<nav class="navbar navbar-expand-lg main-navbar">
    <div class="form-inline mr-auto"></div>
    <ul class="navbar-nav navbar-right">
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <i class="fas fa-user-circle mr-1"></i>
        <div class="d-sm-none d-lg-inline-block">
          {{ Auth::user()->pegawai->nama }}  
        </div></a>
        <div class="dropdown-menu dropdown-menu-right">
          {{-- <div class="dropdown-divider"></div> --}}
          <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>