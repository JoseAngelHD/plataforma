<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

<!-- Brand section -->
<div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
        <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
        <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
    </a>
</div>


  <div class="menu-inner-shadow"></div>

  <!-- Sidebar menu content -->
  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <!-- Colegios -->
    <li class="menu-item  {{ request()->routeIs('schools*') ? 'active' : '' }}">
      <a href="{{ route('schools.index') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-buildings"></i>
        <div>Colegios</div>
      </a>
    </li>


    <!-- Usuarios -->
    <li class="menu-item {{ request()->is('users*') ? 'active' : '' }}">
      <a href="{{ route('users.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Usuarios</div>
      </a>
    </li>

    <!-- Puedes agregar más ítems aquí si lo necesitas -->
  </ul>
</aside>
