<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
    <ul class="nav flex-column">
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted text-uppercase">
        <span>Administrator</span>
        <!-- <a class="link-secondary" href="#" aria-label="Add a new report">
          <span data-feather="plus-circle" class="align-text-bottom"></span>
        </a> -->
      </h6>
      <!-- <div class="mx-3 border border-dark rounded-pill"> -->
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('admin_dashboard') }}">
          <span class="align-text-center me-1"><i class="bi bi-house-door"></i></span>
          Dashboard        
        </a>
      </li>
      <!-- </div> -->
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/customers') ? 'active' : '' }}" href="{{ route('customers') }}">
        <span class="align-text-center me-1"><i class="bi bi-people" style="font-size: 1rem;"></i></span>
          Informasi Customer
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/trainer') ? 'active' : '' }}" href="{{ route('trainers') }}">
        <span class="align-text-center me-1"><i class="bi bi-people" style="font-size: 1rem;"></i></span>
          Informasi Trainer
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/pelatihan') ? 'active' : '' }}" href="{{ route('trainings') }}">
          <span class="align-text-center me-1"><i class="bi bi-file-earmark-text" style="font-size: 1rem;"></i></span>
          Daftar Pelatihan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/riwayat-pelatihan') ? 'active' : '' }}" href="{{ route('training_records') }}">
           <span class="align-text-center me-1"><i class="bi bi-list-check" style="font-size: 1rem;"></i></span>
          Riwayat Pelatihan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/transaksi') ? 'active' : '' }}" href="{{ route('invoice') }}">
        <span class="align-text-center me-1"><i class="bi bi-cash-coin" style="font-size: 1rem;"></i></span>
          Transaksi Pembayaran
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/lowongan-kerja') ? 'active' : '' }}" href="{{ route('vacancies') }}">
        <span class="align-text-center me-1"><i class="bi bi-briefcase" style="font-size: 1rem;"></i></span>
          Lowongan Pekerjaan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link mx-2 rounded {{ Request::is('admin/profile') ? 'active' : '' }}" href="{{ route('admin_profile') }}">
        <span class="align-text-center me-1"><i class="bi bi-gear" style="font-size: 1rem;"></i></span>
          Pengaturan Akun
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="layers" class="align-text-bottom"></span>
          Riwayat Pelatihan
        </a>
      </li> -->
    </ul>
  </div>
</nav>
