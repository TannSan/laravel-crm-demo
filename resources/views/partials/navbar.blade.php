@section('navbar')
<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    @if(Route::currentRouteName() == 'company.index' || Route::currentRouteName() == 'employee.index')
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <!-- Search form -->
            <form action="/{{ Route::currentRouteName() == 'company.index' ? 'company' : 'employee' }}" method="POST" class="form-inline ml-3">
                @method('GET')
                @csrf
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="text" placeholder="Search" aria-label="Search" id="search" name="search" value="{{ old('search', Request::exists('search') ? Request::input('search') : '') }}">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit" role="button"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </li>
    </ul>
    @endif
</nav>
<!-- /.navbar -->
@endsection