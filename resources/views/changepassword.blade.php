@extends('layout')

@section('con')
    <link rel="stylesheet" href="{{ asset('assets/css/changepassword.css') }}">
    <div class="block block-rounded">
    <div class="block-content">
        <form action="" method="POST" enctype="multipart/form-data" id="change-password-form" data-success="{{session("success")}}">
            @csrf
            <h2 class="content-heading pt-0">Change password</h2>
            <div class="form-group">
                <label for="new_password" class="text-black">New password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password" class="text-black">Confirm password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="show-password" name="show-password">
                    <label class="form-check-label text-black" for="show-password">Show password</label>
                </div>
            </div>
            <div class="clearfix form-group">
                <button type="button" class="float-right mx-1 btn btn-hero-primary cancel-btn"
                id="cancel_button">CANCEL</button>
                <button type="button" class="float-right mx-1 btn btn-hero-primary submit-btn"
                    id="save_button" data-form="user_form">SAVE</button>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/js/changepassword.js') }}"></script>
@endsection