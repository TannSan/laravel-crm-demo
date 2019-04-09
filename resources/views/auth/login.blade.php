@extends('layouts.guest')

@section('page_title') {{ __('auth.login') }}
@endsection

@section('content')

<div class="card-body">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="sr-only sr-only-focusable">{{ __('crm.email') }}</label>
            <div class="input-group mb-3">
                <input id="email" name="email" type="email" placeholder="{{ __('crm.email') }}" class="form-control{{ $errors->has('email') ? ' bg-danger border-danger' : '' }}" value="{{ old('email') }}" autofocus>
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="sr-only sr-only-focusable">{{ __('Password') }}</label>
            <div class="input-group mb-3">
                <input id="password" name="password" type="password" placeholder="{{ __('Password') }}" class="form-control{{ $errors->has('password') ? ' bg-danger border-danger' : '' }}" value="">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12 text-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old( 'remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection