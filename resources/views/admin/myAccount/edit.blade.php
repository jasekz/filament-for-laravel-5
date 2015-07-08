@extends('layouts.base_private') @section('content')
<h1 class="pull-left">{{ trans('app.myAccount') }}</h1>
<div class="clearfix"></div>
<div>
    <form
        action="{{ route('admin.account.store') }}"
        method="post"
        id="edit-user-form"
        class="ajaxSubmission">

        <input
            type="hidden"
            name="id"
            value="{{ $entry->id }}">
        <input
            type="hidden"
            name="redirect"
            value="{{ \URL::previous() == \URL::current() ? route('admin.dashboard') : \URL::previous() }}">

        <fieldset class="well">

            <!-- Fields -->
            <div class="form-group">
                <label>{{ trans('app.firstName') }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="first_name"
                    name="first_name"
                    placeholder="e.g. John"
                    value="{{ $entry->first_name }}">
            </div>

            <div class="form-group">
                <label>{{ trans('app.lastName') }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="last_name"
                    name="last_name"
                    placeholder="e.g. Smith"
                    value="{{ $entry->last_name }}">
            </div>

            <div class="form-group">
                <label>{{ trans('app.email') }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="e.g. johndoe@yourwebsitedomain.com"
                    value="{{ $entry->email }}">
            </div>
            <div class="form-group">
                <label>{{ trans('app.password') }}</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password">
            </div>
            <div class="form-group">
                <label>{{ trans('app.confirmPassword') }}</label>
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation">
            </div>

            <hr>

            <!-- Buttons -->
            <button
                type="button"
                class="btn btn-primary submit-form"
                action="save">{{ trans('app.save') }}</button>

            <button
                type="button"
                class="btn btn-success submit-form"
                action="saveAndExit">{{ trans('app.saveAndExit') }}</button>


            <a
                href="{{ route('admin.users.index') }}"
                class="btn btn-default">{{ trans('app.cancel') }}</a>
        </fieldset>
    </form>
</div>
@endsection
