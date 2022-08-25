<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
    <ul class="nav flex-column">
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted text-uppercase">
        <span>Trainer</span>
      </h6>
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('admin_dashboard') }}">
          <span class="align-text-center me-1"><i class="bi bi-house-door"></i></span>
          Dashboard        
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/pelatihan') ? 'active' : '' }}" href="{{ route('trainings') }}">
          <span class="align-text-center me-1"><i class="bi bi-file-earmark-text" style="font-size: 1rem;"></i></span>
          Daftar Pelatihan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/profile') ? 'active' : '' }}" href="{{ route('admin_profile') }}">
        <span class="align-text-center me-1"><i class="bi bi-gear" style="font-size: 1rem;"></i></span>
          Pengaturan Akun
        </a>
      </li>
    </ul>
  </div>
</nav>
