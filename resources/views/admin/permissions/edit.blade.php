@extends('layouts.base_private') @section('content')
<h1 class="pull-left">{{ trans('app.editPermission') }} {!! trans('app.sep') !!} {{ $entry->display_name }}</h1>
<div class="clearfix"></div>
<div>
    <form
        action="{{ route('admin.permissions.store') }}"
        method="post"
        id="edit-permission-form"
        class="ajaxSubmission">
        <input
            type="hidden"
            name="id"
            value="{{ $entry->id }}">
        <input
            type="hidden"
            name="redirect"
            value="{{ \URL::previous() == \URL::current() ? route('admin.permissions.index') : \URL::previous() }}">
        <fieldset class="well">
            <!-- Fields -->
            <div class="form-group">
                <label>{{ trans('app.name') }}</label>
                <input
                    type="text"
                    class="form-control"
                    disabled
                    placeholder="e.g. admin"
                    disabled
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
                href="{{ route('admin.permissions.index') }}"
                class="btn btn-default">{{ trans('app.cancel') }}</a>
        </fieldset>
    </form>
</div>
@endsection
