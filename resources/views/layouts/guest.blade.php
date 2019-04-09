<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#2c8abe">
  <meta name="msapplication-TileColor" content="#2b5797">
  <meta name="theme-color" content="#ffffff">
</head>

<body class="guest h-100">

  <!-- Main content -->
  <div class="container h-100">

    <div class="row align-items-center justify-content-center h-100">
      <div class="col-10 col-md-8 col-lg-6 col-xl-4">
        <div class="card">

          <div class="card-header bg-dark text-center text-sm-left">
            @if(Route::currentRouteName() == 'login')
            <a href="https://github.com/TannSan/simple-crm-demo" class="float-sm-left mr-0 mr-sm-3" title="{{ __('crm.visit', ['Name'=>'Laravel CRM Demo github']) }}"><img src="/android-chrome-192x192.png" alt="{{ config('app.name') }} Logo" class="brand-image" /></a>
            <div class="brand-text">
              <h1 class="mt-3"><a href="https://github.com/TannSan/simple-crm-demo" title="{{ __('crm.visit', ['Name'=>'Laravel CRM Demo github']) }}">{{ config('app.name') }}</a></h1>
              <h2 class="mb-0">@yield('page_title', 'Welcome')</h2>
            </div>
            @else
            <a href="/" class="float-sm-left mr-0 mr-sm-3" title="{{ __('crm.return_to_login') }}"><img src="/android-chrome-192x192.png" alt="{{ config('app.name') }} Logo" class="brand-image" /></a>
            <div class="brand-text">
              <h1 class="mt-3"><a href="/" title="{{ __('crm.return_to_login') }}">{{ config('app.name') }}</a></h1>
              <h2 class="mb-0">@yield('page_title', 'Welcome')</h2>
            </div>
            @endif
          </div>

          @if ($errors->any())
          <div class="card-body alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <div class="card-body">
            @yield('content')
          </div>

        </div>
      </div>
    </div>

  </div>
  <!-- /.container -->

</body>
</html>