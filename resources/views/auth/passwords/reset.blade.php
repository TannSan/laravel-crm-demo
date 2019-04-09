@extends('layouts.guest')

@section('page_title') {{ __('Reset Password') }}
@endsection

@section('content')

<div class="card-body">
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email" class="sr-only sr-only-focusable">{{ __('crm.email') }}</label>
            <div class="input-group mb-3">
                <input id="email" name="email" type="email" placeholder="{{ __('crm.email') }}" class="form-control{{ $errors->has('email') ? ' bg-danger border-danger' : '' }}" value="{{ $email ?? old('email') }}" autofocus>
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="sr-only sr-only-focusable">{{ __('Password') }}</label>
            <div class="input-group mb-3">
                <input id="password" name="password" type="password" placeholder="{{ __('Password') }}" class="form-control{{ $errors->has('password') ? ' bg-danger border-danger' : '' }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="password-confirm" class="sr-only sr-only-focusable">{{ __('Confirm Password') }}</label>
            <div class="input-group mb-3">
                <input id="password-confirm" name="password_confirmation" type="password" placeholder="{{ __('Confirm Password') }}" class="form-control{{ $errors->has('password-confirm') ? ' bg-danger border-danger' : '' }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">{{ __('Reset Password') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection