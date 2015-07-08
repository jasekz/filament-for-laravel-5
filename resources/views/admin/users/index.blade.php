@extends('layouts.base_private') @section('content')
<div class="table-responsive">
    <h1 class="pull-left">{{ trans('app.users') }}</h1>
    <div class="form-group form-inline pull-right mt-25">
        <div class="input-group">
            <form
                action="{{ route('admin.users.index') }}"
                method="get"
                id="search-form">
                
                <input
                    type="text"
                    class="form-control filter"
                    name="filter[users.first_name|users.last_name]"
                    value="{{ array_get(Input::get('filter'), 'users.first_name|users.last_name') }}"
                    placeholder="{{ trans('app.search') }}">
            </form>
            
            <a
                href="#"
                class="input-group-addon"
                onclick="$('#search-form').submit();return false;"><i class="fa fa-search"></i></a>
        </div>
        <a
            href="{{ route('admin.users.index') }}"
            class="btn btn-default"><i class="fa fa-undo"></i> {{ trans('app.resetSearch') }}</a> <a
            href="{{ route('admin.users.create') }}"
            class="btn btn-default"><i class="fa fa-plus"></i> {{ trans('app.addNew') }}</a>
    </div>
    
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th
                    class="sortable"
                    id="first_name">{{ trans('app.firstName') }}</th>
                <th
                    class="sortable"
                    id="last_name">{{ trans('app.lastName') }}</th>
                <th
                    width="100"
                    class="sortable"
                    id="email">{{ trans('app.email') }}</th>
                <th>{{ trans('app.roles') }}</th>
                <th width="150">{{ trans('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($entries->isEmpty())
            <tr>
                <td colspan="4">{{ trans('app.noResults') }}</td>
            </tr>
            @else @foreach ($entries as $entry)
            <tr>
                <td>{{ $entry->first_name }}</td>
                <td>{{ $entry->last_name }}</td>
                <td>{{ $entry->email }}</td>
                <td>
                @foreach($entry->roles as $role)
                {{ $role->display_name }}<br>
                @endforeach
                </td>
                <td>
                    <div class="btn-group dropup">
                        <button
                            type="button"
                            class="btn btn-default">{{ trans('app.action') }}</button>
                            
                        <button
                            type="button"
                            class="btn btn-default dropdown-toggle"
                            data-toggle="dropdown"
                            aria-expanded="false">
                            <span class="caret"></span> <span class="sr-only">{{ trans('app.action') }}</span>
                        </button>
                        
                        <ul
                            class="dropdown-menu dropdown-menu-right"
                            role="menu">
                            <li><a href="{{ route('admin.users.edit', $entry->id) }}">{{ trans('app.edit') }}</a></li>
                            <li><a
                                href="#"
                                class="delete-entry"
                                url="{{ route('admin.users.destroy', $entry->id) }}">{{ trans('app.delete') }}</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            @endforeach @endif
        </tbody>
    </table>
</div>
<div class="row">
    <div class="pull-left">{!! $entries->render() !!}</div>
    <div class="pull-right">
        <select class="form-control show-x-entries"> @for($i=10;$i<=100;$i+=30)
            <option
                value="{{ route('admin.users.index', ['showEntries' => $i]) }}"
                {{ \Input::get('showEntries') ==
                $i ? 'selected="selected"' : '' }} >{{ trans('app.showXEntries', ['num' => $i]) }}</option> @endfor
        </select>
    </div>
</div>
@endsection
