<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

      <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">CRTCREW</a>
      </div>

      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('admin.dashboard') }}">CC</a>
      </div>

      <ul class="sidebar-menu">

        {{-- always show Dashboard --}}
        <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fire"></i> <span>Dashboard</span>
          </a>
        </li>

        {{-- hide everything else on profile.* pages --}}
        @unless(request()->routeIs('profile.*') || request()->is('profile*'))
          <li class="{{ request()->is('admin/courses*') || request()->is('admin/course-content*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.courses.index') }}">
              <i class="fas fa-th-large"></i> <span>Courses</span>
            </a>
          </li>

          <li class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.orders.index') }}">
              <i class="far fa-file-alt"></i> <span>Orders</span>
            </a>
          </li>
        @endunless

      </ul>

    </aside>
  </div>
