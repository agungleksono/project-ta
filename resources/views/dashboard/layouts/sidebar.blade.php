<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="#">
          <span data-feather="home" class="align-text-bottom"></span>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span class="align-text-center me-1"><i class="bi bi-person" style="font-size: 1rem;"></i></span>
          Admin
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
        <span class="align-text-center me-1"><i class="bi bi-people" style="font-size: 1rem;"></i></span>
          Peserta
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
        <span class="align-text-center me-1"><i class="bi bi-people" style="font-size: 1rem;"></i></span>
          Trainer
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span class="align-text-center me-1"><i class="bi bi-file-earmark-text" style="font-size: 1rem;"></i></span>
          Manajemen Pelatihan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
           <span class="align-text-center me-1"><i class="bi bi-list-check" style="font-size: 1rem;"></i></span>
          Riwayat Pelatihan
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