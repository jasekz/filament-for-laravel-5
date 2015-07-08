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
                class="sr-only">{{ trans('app.email') }}</label>
            <input
                id="email"
                type="text"
                name="email"
                class="form-control"
                placeholder="admin@yoursite.com"
                autofocus >
            <br>
            <button class="btn btn-lg btn-primary btn-block submit">{{ trans('app.resetPassword') }}</button>
            <br>
            <a href="{{ route('admin.auth.login') }}">{{ trans('app.login') }}</a>
        </form>
    </div>


</div>
@endsection



