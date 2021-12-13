@extends('vendor.profile.layouts.master')
@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop
@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))
@section('body')




<div class="modal fade" id="new-submission-modal" tabindex="-1" role="dialog" aria-labelledby="new-submission-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex " style="display: flex; ">
                    <h5 class="modal-title mr-auto" id="exampleModalLabel">Create A new Submission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="    margin-left: auto;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="background:#fff"> 
                        <div class="submission-box" id="submission-section" data-fill-all-fields="@lang('general.fill_all_fields')">
                            <form id="validate-submission-form" enctype="multipart/form-data" method="POST" action="{{route('user.submission')}}">
                                @csrf 
                                <div class="form-group col-12 " style="padding:0px 15px ">
                                    <label for="title">@lang('general.title'): <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="form-group" style="padding:0px 15px ">
                                    <label for="description">@lang('general.description'): <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="description" name="description" required>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="category">@lang('general.category'): <span class="text-danger">*</span></label>
                                    <select id="category" name="category" class="form-control">
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-lg-6 ">
                                    <label for="platform">@lang('general.platform'): <span class="text-danger">*</span></label>
                                    <select id="platform" name="platform" class="form-control">
                                        @foreach($platforms as $platform)
                                        <option value="{{ $platform->id }}">
                                            {{ $platform->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="developer">@lang('general.developer'): <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="developer" name="developer" required>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label for="url">@lang('general.download_page_url'): <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="url" name="url" required>
                                </div> 
                                <div class="form-group" style="padding:0px 15px ">
                                    <label for="image">@lang('general.image'): <span class="text-danger">*</span></label>
                                    <input type="file" accept="image/*" class="form-control-file" id="image" name="image" required>
                                </div>
                                <div class="form-group" style="padding:0px 15px ">
                                    <button type="submit" class="btn m-0 btn-success" onclick="if($('#validate-submission-form')[0].checkValidity())document.getElementById('validate-submission-form').submit();">@lang('general.submit')</button>
                                </div>
                            </form> 
                        </div> 
                    </div> 
                </div> 
            </div>
        </div>
    </div>


    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="{{ url(config('adminlte.dashboard_url', 'admin')) }}" class="navbar-brand">
                                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                            </a>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                            <ul class="nav navbar-nav">
                                @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    @else
                        <!-- Logo -->
                            <a href="{{ url(config('adminlte.dashboard_url', 'admin')) }}" class="logo">
                                <!-- mini logo for sidebar mini 50x50 pixels -->
                                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                                <!-- logo for regular state and mobile devices -->
                                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
                            </a>

                            <!-- Header Navbar -->
                            <nav class="navbar navbar-static-top" role="navigation">
                                <!-- Sidebar toggle button-->
                                <a href="#" class="sidebar-toggle fa5" data-toggle="push-menu" role="button">
                                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                                </a>
                            @endif
                            <!-- Navbar Right Menu -->
                                <div class="navbar-custom-menu">

                                    <ul class="nav navbar-nav">
                                        <li class="dropdown messages-menu">
                                            <a href="/" target="_blank"><i class="fas fa-external-link-square-alt"></i> @lang('admin.browse_site')</a></li>
                                        <li>
                                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                                </a>
                                            @else
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                                </a>
                                                <form id="logout-form"
                                                      action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}"
                                                      method="POST" class="display-none">
                                                    @if(config('adminlte.logout_method'))
                                                        {{ method_field(config('adminlte.logout_method')) }}
                                                    @endif
                                                    {{ csrf_field() }}
                                                </form>
                                            @endif
                                        </li>
                                    @if(config('adminlte.right_sidebar') and (config('adminlte.layout') != 'top-nav'))
                                        <!-- Control Sidebar Toggle Button -->
                                            <li>
                                                <a href="#" data-toggle="control-sidebar"
                                                   @if(!config('adminlte.right_sidebar_slide')) data-controlsidebar-slide="false" @endif>
                                                    <i class="{{config('adminlte.right_sidebar_icon')}}"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @if(config('adminlte.layout') == 'top-nav')
                    </div>
                    @endif
                </nav>
        </header>

    @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu" data-widget="tree">
                        @include('vendor.profile.layouts.menu-item')
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>
    @endif

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
                <div class="container">
                @endif

                <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h4>@yield('content_header')</h4>
                    </section>

                    <!-- Main content -->
                    <section class="content">

                        @yield('content')

                    </section>
                    <!-- /.content -->
                    @if(config('adminlte.layout') == 'top-nav')
                </div>
                <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

        @hasSection('footer')
            <footer class="main-footer">
                @yield('footer')
            </footer>
        @endif

        @if(config('adminlte.right_sidebar') and (config('adminlte.layout') != 'top-nav'))
            <aside class="control-sidebar control-sidebar-{{config('adminlte.right_sidebar_theme')}}">
                @yield('right-sidebar')
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        @endif

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
