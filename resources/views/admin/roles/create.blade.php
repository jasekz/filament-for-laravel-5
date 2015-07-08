@extends('layouts.base_private') @section('content')
<h1 class="pull-left">{{ trans('app.newRole') }}</h1>
<div class="clearfix"></div>
<div>
    <form
        action="{{ route('admin.roles.store') }}"
        method="post"
        id="add-role-form"
        class="ajaxSubmission">
        <input
            type="hidden"
            name="redirect"
            value="{{ \URL::previous() == \URL::current() ? route('admin.roles.index') : \URL::previous() }}">
        <fieldset class="well">
            <!-- Fields -->
            <div class="form-group">
                <label>{{ trans('app.name') }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    placeholder="e.g. admin">
            </div>
            <div class="form-group">
                <label>{{ trans('app.displayName') }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="display_name"
                    name="display_name"
                    placeholder="e.g. Administrator">
            </div>
            <div class="form-group">
                <label>{{ trans('app.description') }}</label>
                <textarea
                    class="form-control"
                    id="description"
                    name="description"
                    placeholder="e.g. Administrator"></textarea>
            </div>
            <div class="form-group">
                <label>{{ trans('app.permissions') }}</label> <select
                    multiple
                    class="form-control"
                    id="permission_id"
                    name="permission_id[]"> @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}">{{ $permission->display_name }}</option> @endforeach
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
                href="{{ route('admin.roles.index') }}"
                class="btn btn-default">{{ trans('app.cancel') }}</a>
        </fieldset>
    </form>
</div>
@endsection
