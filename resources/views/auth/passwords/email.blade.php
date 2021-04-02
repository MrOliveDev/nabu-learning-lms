@extends('layouts.app')

@section('content')


<div class="p-3 w-100">
    <!-- Header -->
    <div class="text-center">
        <a class="link-fx text-warning font-w700 font-size-h1" href="index.html">
            <span class="text-dark">Dash</span><span class="text-warning">mix</span>
        </a>
        <p class="text-uppercase font-w700 font-size-sm text-muted">Password Reminder</p>
    </div>
    <!-- END Header -->

    <!-- Reminder Form -->
    <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.min.js which was auto compiled from _es6/pages/op_auth_reminder.js) -->
    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
    <div class="row no-gutters justify-content-center">
        <div class="col-sm-8 col-xl-6">
            <form class="js-validation-reminder" action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group py-3">
                    <input id="email" type="email" class="form-control form-control-lg form-control-alt" name="username" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Username or Email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-block btn-hero-lg btn-hero-warning">
                        <i class="fa fa-fw fa-reply mr-1"></i> Send Password Reset Link
                    </button>
                    <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                        <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('login') }}">
                            <i class="fa fa-sign-in-alt text-muted mr-1"></i> Sign In
                        </a>
                        <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('register') }}">
                            <i class="fa fa-plus text-muted mr-1"></i> New Account
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <!-- END Reminder Form -->
</div>
@endsection