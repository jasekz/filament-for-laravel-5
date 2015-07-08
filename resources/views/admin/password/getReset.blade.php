@extends('layouts.base_public') @section('content')
<div class="container">

    <div class="col-md-4 col-md-offset-4">
        <form
            id="admin-reset-password-form"
            method="post"
            class="form-signin form-group ajaxSubmission">
            <input
                type="hidden"
                name="token"
                value="{{ $token }}">

            <h2 class="form-signin-heading">{{ Config::get('app.appname') }}</h2>

            <div class="form-group">
                <label
                    class="sr-only">{{ trans('app.email') }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="e.g. johndoe@yourwebsitedomain.com">
            </div>
            <div class="form-group">
                <label
                    class="sr-only">{{ trans('app.password') }}</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="password" >
            </div>
            <div class="form-group">
                <label
                    class="sr-only">{{ trans('app.confirmPassword') }}</label>
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="password" >
            </div>

            <button class="btn btn-lg btn-primary btn-block submit">Sign in</button>
            <br> <a href="{{ route('admin.password.forgot_password') }}">{{ trans('app.resetPassword') }}</a>
        </form>
    </div>


</div>
@endsection

