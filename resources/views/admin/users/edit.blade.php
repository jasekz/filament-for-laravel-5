@extends('layouts.base_private') @section('content')
<h1 class="pull-left">{{ trans('app.editUser') }} {!! trans('app.sep') !!} {{ $entry->email }}</h1>
<div class="clearfix"></div>
<div>
    <form
        action="{{ route('admin.users.store') }}"
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
                <label>{{ trans('app.roles') }}</label> <select
                    multiple
                    class="form-control"
                    id="role_id"
                    name="role_id[]"> @foreach($roles as $role)
                    <option
                        value="{{ $role->id }}"
                        {{ in_array($role->id, $entry->roles->modelKeys()) ? 'selected="selected"' : '' }} >{{ $role->display_name }}</option> @endforeach
                </select>
            </div>

            <div
                class="form-group laradrop-test"
                laradrop-upload-handler="{{ route('admin.files.store') }}"
                laradrop-file-source="{{ route('admin.files.index') }}"
                laradrop-csrf-token="{{ csrf_token() }}" >
                <label>{{ trans('app.image') }}</label>
                <div class='input-group'>
                    <input
                        class="form-control laradrop-input"
                        type="text"
                        name="image"
                        id='{$name}'>
                    <span class="input-group-btn">
                        <button
                            class='btn btn-default laradrop-select-file'
                            type='button'>{{ trans('app.selectFile') }}</button>
                        <button
                            class='btn btn-danger laradrop-remove-file'
                            type='button'>{{ trans('app.removeFile') }}</button>
                    </span>
                </div>
                <div class="laradrop-file-thumb"></div>
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

            <button
                type="button"
                class="btn btn-danger delete-entry"
                url="{{ route('admin.users.destroy', $entry->id) }}">{{ trans('app.delete') }}</button>

            <a
                href="{{ route('admin.users.index') }}"
                class="btn btn-default">{{ trans('app.cancel') }}</a>
        </fieldset>
    </form>
</div>
@endsection
