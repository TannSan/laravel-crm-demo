@section('sidebar')
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="/img/ducky.png" alt="{{ config('app.name') }} Logo" class="brand-image img-circle elevation-3" />
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
      </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->avatar_url }}" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
                <p class="mb-0 text-warning">{{ Auth::user()->name }} <a href="{{ route('logout') }}" class="ml-1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">[{{ __('Logout') }} <i class="fa fa-sign-out nav-icon"></i>]</a></p>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link{{ Route::currentRouteName() == 'dashboard' ? ' active' : '' }}"><i class="nav-icon fa fa-bar-chart"></i><p>{{ __('crm.dashboard')}}</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('company.index') }}" class="nav-link{{ substr( Route::currentRouteName(), 0, 8 ) === 'company.' ? ' active' : '' }}"><i class="nav-icon fa fa-building"></i><p>{{ __('crm.companies')}}</p></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employee.index') }}" class="nav-link{{ substr( Route::currentRouteName(), 0, 9 ) === 'employee.' ? ' active' : '' }}"><i class="nav-icon fa fa-users"></i><p>{{ __('crm.employees')}}</p></a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</aside>
<!-- /.sidebar -->
@endsection