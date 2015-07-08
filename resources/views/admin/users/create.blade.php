@extends('layouts.base_private') @section('content')
<h1 class="pull-left">{{ trans('app.newUser') }}</h1>
<div class="clearfix"></div>
<div>
    <form
        action="{{ route('admin.users.store') }}"
        method="post"
        id="add-user-form"
        class="ajaxSubmission">
        
        <input
            type="hidden"
            name="redirect"
            value="{{ \URL::previous() == \URL::current() ? route('admin.users.index') : \URL::previous() }}">
            
        <fieldset class="well">
        
            <!-- Fields -->
            <div class="form-group">
                <label>{{ trans('app.firstName') }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="first_name"
                    name="first_name"
                    placeholder="e.g. John">
            </div>
            
            <div class="form-group">
                <label>{{ trans('app.lastName') }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="last_name"
                    name="last_name"
                    placeholder="e.g. Smith">
            </div>
            
            <div class="form-group">
                <label>{{ trans('app.email') }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="e.g. johndoe@yourwebsitedomain.com">
            </div>
            
            <div class="form-group">
                <label>{{ trans('app.roles') }}</label> <select
                    multiple
                    class="form-control"
                    id="role_id"
                    name="role_id[]"> @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->display_name }}</option> @endforeach
                </select>
            </div>
            
            <hr>
            
            <!-- Buttons -->
            <button
                type="button"
                class="btn btn-primary submit-form"
                action="saveAndNew">{{ trans('app.saveAndNew') }}</button>
                
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
