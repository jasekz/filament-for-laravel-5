@extends('layouts.base_public') @section('content')
<div class="container">

    <div class="col-md-4 col-md-offset-4">
        <form
            id="admin-login-form"
            method="post"
            class="form-signin form-group ajaxSubmission">

            <h2 class="form-signin-heading">{{ Config::get('app.appname') }}</h2>

            <label
                for="inputEmail"
                class="sr-only">Email address</label>
            <input
                id="email"
                type="text"
                name="email"
                class="form-control"
                placeholder="admin@yoursite.com"
                autofocus>

            <label
                for="inputPassword"
                class="sr-only">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="form-control"
                placeholder="password">

            <button class="btn btn-lg btn-primary btn-block submit">Sign in</button>
            <br>
            <a href="{{ route('admin.password.forgot_password') }}">{{ trans('app.resetPassword') }}</a>
        </form>
    </div>


</div>
@endsection

