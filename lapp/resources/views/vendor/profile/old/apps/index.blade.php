@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.apps'))

<!-- Info boxes -->
<div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon cpu-load"><i class="fas fa-chart-bar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">@lang('admin.cpu_load') </span>
                <span class="info-box-number">{{$sload}}<small>%</small></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon cached-queries"><i class="fas fa-server"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('admin.cached_queries')</span>
                <span class="info-box-number">{{ number_format($total_cached) }}</span>
                <a href="{{ asset('/admin/settings/clear_cache') }}" id="clear-cache" class="clear-cache" data-cache-clear="@lang('admin.cache_clear_message')">@lang('admin.clear_cache')</a>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon total-apps"><i class="fab fa-android"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('admin.total_apps')</span>
                <span class="info-box-number">{{ number_format($total_apps) }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon total-downloads"><i class="fas fa-chart-pie"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('admin.total_hits')</span>
                <span class="info-box-number">{{ number_format($total_downloads) }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

</div>
<!-- /.row -->

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        @if($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
        @endif

        <!-- general form elements -->
        <div class="box">

            <!-- box-body -->
            <div class="box-body no-padding">

                <a href="{{ asset('/admin/apps/create') }}" class="btn bg-purple btn-flat margin"><i class="fas fa-plus-square"></i>
                    @lang('admin.create_app')</a>
                <div class="table-responsive">
                <table class="table table-striped" id="table" data-delete-prompt="@lang('admin.delete_prompt')" data-yes="@lang('admin.yes')" data-cancel="@lang('admin.cancel')">
                        <tr>
                            <th class="col-md-1">ID</th>
                            <th class="col-md-7">@lang('admin.app_title')</th>
                            <th class="col-md-1">@lang('admin.category')</th>
                            <th class="col-md-1">@lang('admin.platform')</th>
                            <th class="col-md-1">@lang('admin.edit')</th>
                            <th class="col-md-1">@lang('admin.delete')</th>
                        </tr>
                        @foreach($apps as $row)
                        <tr>
                            <td>{{$row['id']}}</td>
                            <td><a href="{{ asset($settings['app_base']) }}/{{ $row->slug }}" class="text-black" target="_blank">{{$row['title']}}</a></td>
                            <td>{{ $row->category_title }}</td>
                            <td>{{ $row->platform_title }}</td>
                            <td><a href="{{action('ApplicationController@edit', $row['id'])}}"
                                    class="btn btn-sm bg-purple"><i class="fas fa-edit"></i> @lang('admin.edit')</a>
                            </td>
                            <td>
                                <form id="delete_from_{{$row->id}}" method="POST"
                                    action="{{action('ApplicationController@destroy', $row['id'])}}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <a href="javascript:void(0);" data-id="{{$row->id}}" class="_delete_data">
                                        <span class="btn btn-sm bg-red"><i class="fas fa-ban"></i>
                                            @lang('admin.delete')</span>
                                    </a>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.general form elements -->

        @if($apps->isEmpty())
        <h6 class="alert alert-danger">@lang('admin.no_record').</h6>
        @endif

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

{{ $apps->onEachSide(1)->links() }}

@endsection