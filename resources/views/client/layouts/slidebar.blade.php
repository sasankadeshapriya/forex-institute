<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

      <div class="sidebar-brand">
        <a href="{{ route('home') }}">CRTCREW</a>
      </div>

      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('home') }}">CC</a>
      </div>

      <ul class="sidebar-menu">

        <li class="{{ request()->is('dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

        <li class="{{ request()->is('entrolled-courses*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('entrolled-courses.index') }}"><i class="fas fa-th-large"></i> <span>My Courses</span></a></li>

        <li class="{{ request()->is('order-list*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('order-list.index') }}"><i class="far fa-file-alt"></i> <span>Orders</span></a></li>

        <li class="{{ request()->is('courses*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('courses.index') }}"><i class="fas fa-pencil-ruler"></i> <span>Shop</span></a></li>
      </ul>

    </aside>
  </div>
