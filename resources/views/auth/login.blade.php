@extends('layouts.app')

@section('content')

<div class="p-3 w-100">
    <!-- Header -->
    <div class="mb-3 text-center">
        <a class="link-fx font-w700 font-size-h1" href="/">
            <span class="text-dark">Nabû&nbsp</span><span class="text-primary">learning</span>
        </a>
        <p class="text-uppercase font-w700 font-size-sm text-muted">Sign In</p>
    </div>
    <!-- END Header -->

    <!-- Sign In Form -->
    <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
    <div class="row no-gutters justify-content-center">
        <div class="col-sm-8 col-xl-6">
            <form class="js-validation-signin" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="py-3">
                    <div class="form-group">
                        <input id="email" type="text" class="form-control @error('username') is-invalid @enderror form-control-lg form-control-alt" id="login-username"  name="username" value="{{ old('username') }}" required autofocus placeholder="Username or Email">
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control @error('username') is-invalid @enderror form-control-lg form-control-alt" name="password" required autocomplete="Password" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-hero-lg btn-hero-primary">
                        <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In
                    </button>
                    <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                        @if (Route::has('password.request'))
                        <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('password.request') }}">
                            <i class="fa fa-exclamation-triangle text-muted mr-1"></i> Forgot password
                        </a>
                        @endif

                        <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('register') }}">
                            <i class="fa fa-plus text-muted mr-1"></i> New Account
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <!-- END Sign In Form -->
</div>
@endsection
