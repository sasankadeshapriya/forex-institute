<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

      <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}">CRTCREW</a>
      </div>

      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('dashboard') }}">CC</a>
      </div>

      <ul class="sidebar-menu">

        <li class="{{ request()->is('dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

        <li class="{{ request()->is('entrolled-courses*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('entrolled-courses.index') }}"><i class="fas fa-th-large"></i> <span>My Courses</span></a></li>

        <li class="{{ request()->is('order-list*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('order-list.index') }}"><i class="fa fa-shopping-cart"></i> <span>Orders</span></a></li>
      </ul>

    </aside>
  </div>
