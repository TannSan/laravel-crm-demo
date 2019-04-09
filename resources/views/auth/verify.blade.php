@extends('layouts.guest')

@section('page_title') {{ __('Verify Your Email Address') }}
@endsection

@section('content') @if(session('resent'))
<div class="card-body alert-success" role="alert">
    {{ __('A fresh verification link has been sent to your email address.') }}
</div>
@endif

<div class="card-body">
    <p class="card-text">{{ __('Before proceeding, please check your email for a verification link.') }} {{ __('If you did not receive the email')
    }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.</p>
</div>
@endsection