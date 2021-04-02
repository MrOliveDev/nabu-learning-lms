@extends('layouts.app')

@section('content')

<div class="p-3 w-100">
    <!-- Header -->
    <div class="mb-3 text-center">
        <a class="link-fx text-success font-w700 font-size-h1" href="index.html">
            <span class="text-dark">Dash</span><span class="text-success">mix</span>
        </a>
        <p class="text-uppercase font-w700 font-size-sm text-muted">Create New Account</p>
    </div>
    <!-- END Header -->

    <!-- Sign Up Form -->
    <!-- jQuery Validation (.js-validation-signup class is initialized in js/pages/op_auth_signup.min.js which was auto compiled from _es6/pages/op_auth_signup.js) -->
    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
    <div class="row no-gutters justify-content-center">
        <div class="col-sm-8 col-xl-6">
            <form class="js-validation-signup" action="{{ route('register') }}" method="POST">
            @csrf
                <div class="py-3">
                    <div class="form-group">
                        <!-- <input type="text" class="form-control form-control-lg form-control-alt" id="signup-username" name="signup-username" > -->
                        <input id="name" type="text" class="form-control form-control-lg form-control-alt" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Username">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="email" type="email" class="form-control form-control-lg form-control-alt" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control form-control-lg form-control-alt" name="password" required autocomplete="new-password" placeholder="Password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control form-control-lg form-control-alt" required autocomplete="new-password" placeholder="Password Confirm">

                    </div>
                    <!-- <div class="form-group">
                        <div class="custom-control custom-checkbox custom-control-primary">
                            <input type="checkbox" class="custom-control-input" id="signup-terms" name="signup-terms">
                            <label class="custom-control-label" for="signup-terms">I agree to Terms &amp; Conditions</label>
                        </div>
                    </div> -->
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-hero-lg btn-hero-success">
                        <i class="fa fa-fw fa-plus mr-1"></i> Sign Up
                    </button>
                    <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                        <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('login') }}">
                            <i class="fa fa-sign-in-alt text-muted mr-1"></i> Sign In
                        </a>
                        <!-- <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="#" data-toggle="modal" data-target="#modal-terms">
                            <i class="fa fa-book text-muted mr-1"></i> Read Terms
                        </a> -->
                    </p>
                </div>
            </form>
        </div>
    </div>
    <!-- END Sign Up Form -->
</div>
@endsection