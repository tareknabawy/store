{{-- <form action="{{ asset('/admin/search') }}" method="GET" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="term" class="form-control" placeholder="
            @lang('admin.search_apps')
            ">
        <span class="input-group-btn">
            <button type="submit" id="search-btn" class="btn btn-flat">
                <i class="fas fa-search"></i>
            </button>
        </span>
    </div>
</form>
 --}}
{{-- <li class="header">{{auth()->user()->name}}</li> --}}
<div class="p-0" style="display:flex;justify-content: center; align-items: center;padding: 20px 0px;">
    <div class="" style="padding: 0px;">
        
    
    <img src="https://cdn-icons-png.flaticon.com/512/147/147144.png" style="width:70px;padding: 5px;border-radius: 50%;">
    <br>
    <div class="text-center">
        <span style="color: #fff;padding: 8px 0px;display: inline-block;">{{auth()->user()->name}}</span>
    </div>
    </div>
    
</div>
{{-- <li class="treeview{{ Request::is('admin/apps*', 'admin', 'admin/search')  ? ' active' : '' }}">
    <a href="#">
        <i class="fas fa-mobile-alt "></i>
        <span class="ml-5">
            @lang('admin.apps')
        </span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('admin/apps', 'admin', 'admin/apps/*/edit', 'admin/search') ? 'active' : '' }}">
            <a href="{{ asset('/admin/apps') }}">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    @lang('admin.apps')
                </span>
            </a>
        </li>
        <li class="{{ Request::is('admin/apps/create') ? 'active' : '' }}">
            <a href="{{ asset('/admin/apps/create') }}">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    @lang('admin.create_app')
                </span>
            </a>
        </li>
    </ul>
</li> --}}

<li class="{{ Request::is('user/profile*') ? 'active' : '' }}">
    <a href="{{route('user.profile')}}">
        <i class="fas fa-home "></i>
        <span class="ml-5">
            Home
        </span>
    </a>
</li>
<li class="{{ Request::is('user/submissions*') ? 'active' : '' }}">
    <a href="{{route('user.submissions')}}">
        <i class="fas fa-pallet "></i>
        <span class="ml-5">
            My Submissions
        </span>
        @php
        $pending_submissions=\App\Submission::where('user_id',auth()->user()->id)->count();
        @endphp
        @if ($pending_submissions >= 1)
        <span class="pull-right-container">
            <small class="label pull-right " style="background: #af1f33;font-weight: normal;">
                {{$pending_submissions}}</small>
        </span>
        @endif

    </a>
</li>
<li class="{{ Request::is('user/applications*') ? 'active' : '' }}">
    <a href="{{route('user.applications')}}">
        <i class="fas fa-box-open "></i>
        <span class="ml-5">
            My Apps
        </span>

        @php
        $my_apps=\App\Application::where('owner_id',auth()->user()->id)->count();
        @endphp
        @if ($my_apps >= 1)
        <span class="pull-right-container">
            <small class="label pull-right " style="background: #af1f33;font-weight: normal;">
                {{$my_apps}}</small>
        </span>
        @endif
    </a>
</li>
<li >
    <a href="{{env("APP_URL")}}" target="_blank">
        <i class="fas fa-fas fa-external-link-square-alt "></i>
        <span class="ml-5">
            View Website
        </span> 
    </a>
</li>
<li >
    <a href="{{env("APP_URL")}}/admin" >
        <i class="fas fa-fas fa-cogs "></i>
        <span class="ml-5">
            Admin Panel
        </span> 
    </a>
</li>



<li class="">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-power-off "></i>
        <span class="ml-5 ">
            Logout
        </span>
    </a>
</li>
