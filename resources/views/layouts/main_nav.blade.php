<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">+-</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">{{ Config::get('app.appname') }}</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">         
        <li><a href="{{ URL::route('admin.dashboard') }}" title="{{ trans('app.home') }}" class="{{ isset($active) && $active == 'home' ? 'active' : '' }}" ><span>{{ trans('app.home') }}</span></a></li></li>   
        <li class="dropdown {{ isset($active) && $active == 'access-control' ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" title="{{ trans('app.accessControl') }}"  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('app.accessControl') }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            @if(\Auth()->user()->can('manage-users'))
            <li><a href="{{ route('admin.users.index') }}">{{ trans('app.users') }}</a></li>
            @endif
            
            @if(\Auth()->user()->can('manage-roles'))
            <li><a href="{{ route('admin.roles.index') }}">{{ trans('app.roles') }}</a></li>
            @endif 
            
            @if(\Auth()->user()->can('manage-permissions'))
            <li><a href="{{ route('admin.permissions.index') }}">{{ trans('app.permissions') }}</a></li>
            @endif
            
          </ul>
        </li>
        <li><a href="{{ URL::route('admin.assemblies.index') }}" title="{{ trans('crt::app.assemblies') }}" class="{{ isset($active) && $active == 'assemblies' ? 'active' : '' }}" ><span>{{ trans('crt::app.assemblies') }}</span></a></li></li>   
        <li><a href="{{ URL::route('admin.products.index') }}" title="{{ trans('crt::app.products') }}" class="{{ isset($active) && $active == 'products' ? 'active' : '' }}" ><span>{{ trans('crt::app.products') }}</span></a></li></li>   
        <li><a href="{{ URL::route('admin.manufacturers.index') }}" title="{{ trans('crt::app.manufacturers') }}" class="{{ isset($active) && $active == 'manufacturers' ? 'active' : '' }}" ><span>{{ trans('crt::app.manufacturers') }}</span></a></li></li>   
        
      </ul>
      <ul class="nav navbar-nav navbar-right"> 
        <li class="dropdown {{ isset($active) && $active == 'admin' ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" title="{{ \Auth()->user()->email }}"  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{!! trans('app.loggedInAs', ['user' => \Auth()->user()->email]) !!} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ URL::route('admin.account.edit', 0) }}" title="{{ trans('app.myAccount') }}"><span>{{ trans('app.myAccount') }}</span></a></li></li> 
            <li><a href="{{ URL::route('admin.auth.logout') }}" title="{{ trans('app.logout') }}"><span>{{ trans('app.logout') }}</span></a></li></li>             
          </ul>
        </li>           
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>