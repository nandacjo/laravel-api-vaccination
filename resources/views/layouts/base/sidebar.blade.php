<nav id="sidebar" class="sidebar js-sidebar">
  <div class="sidebar-content js-simplebar">
    <a class="sidebar-brand" href="index.html">
      <span class="align-middle">AdminKit</span>
    </a>

    <ul class="sidebar-nav">
      <li class="sidebar-header">
        Master
      </li>

      <li class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="sidebar-link" href="index.html">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
        </a>
      </li>

      <li class="sidebar-item {{ request()->is('societies*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('societies.index') }}">
          <i class="align-middle" data-feather="users"></i> <span class="align-middle">Society</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="pages-sign-in.html">
          <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Sign In</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="pages-sign-up.html">
          <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Sign Up</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="pages-blank.html">
          <i class="align-middle" data-feather="book"></i> <span class="align-middle">Blank</span>
        </a>
      </li>
    </ul>
  </div>
</nav>
