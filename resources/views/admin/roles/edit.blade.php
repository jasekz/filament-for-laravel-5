@extends('layouts.base_private') @section('content')
<h1 class="pull-left">{{ trans('app.editRole') }} {!! trans('app.sep') !!} {{ $entry->display_name }}</h1>
<div class="clearfix"></div>
<div>
    <form
        action="{{ route('admin.roles.store') }}"
        method="post"
        id="edit-role-form"
        class="ajaxSubmission">
        <input
            type="hidden"
            name="id"
            value="{{ $entry->id }}">
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
                    disabled
                    placeholder="e.g. admin"
                    value="{{ $entry->name }}">
            </div>
            <div class="form-group">
                <label>{{ trans('app.displayName') }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="display_name"
                    name="display_name"
                    placeholder="e.g. Administrator"
                    value="{{ $entry->display_name }}">
            </div>
            <div class="form-group">
                <label>{{ trans('app.description') }}</label>
                <textarea
                    class="form-control"
                    id="description"
                    name="description"
                    placeholder="e.g. Administrator">{{ $entry->description }}</textarea>
            </div>
            <div class="form-group">
                <label>{{ trans('app.permissions') }}</label> <select
                    multiple
                    class="form-control"
                    id="permission_id"
                    name="permission_id[]"> @foreach($permissions as $permission)
                    <option
                        value="{{ $permission->id }}"
                        {{ in_array($permission->id, $entry->perms->modelKeys()) ? 'selected="selected"' : '' }} >{{ $permission->display_name }}</option> @endforeach
                </select>
            </div>
            <hr>
            <!-- Buttons -->
            <button
                type="button"
                class="btn btn-primary submit-form"
                action="saveAndNew">{{ trans('app.save') }}</button>
            <button
                type="button"
                class="btn btn-success submit-form"
                action="saveAndExit">{{ trans('app.saveAndExit') }}</button>

            <button
                type="button"
                class="btn btn-danger delete-entry"
                url="{{ route('admin.roles.destroy', $entry->id) }}">{{ trans('app.delete') }}</button>
            <a
                href="{{ route('admin.roles.index') }}"
                class="btn btn-default">{{ trans('app.cancel') }}</a>
        </fieldset>
    </form>
</div>
@endsection
