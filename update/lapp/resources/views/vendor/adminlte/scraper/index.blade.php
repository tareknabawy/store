@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.search_apps'))

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

                <!-- search form -->
                <form action="{{ asset('/admin/scraper') }}" method="GET" class="sidebar-form scraper-form">
                    <div class="input-group">
                        <input type="text" name="term" class="form-control text-center sc-search"
                            placeholder="@lang('admin.scraper_search_gp_store')">
                        <span class="input-group-btn">
                            <button type="submit" id="search-btn" class="btn btn-flat sc-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <!-- /.search form -->

                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th class="col-md-1">@lang('admin.image')</th>
                            <th class="col-md-9">@lang('admin.title')</th>
                            <th class="col-md-1">@lang('admin.status')</th>
                            <th class="col-md-1">@lang('admin.submit')</th>
                        </tr>
                        @foreach($apps as $row)
                        <tr>@php $scraper_query = DB::table('applications')->where('url', $row['url'])->first(); @endphp
                            <td><a href="{{$row['url']}}" target="_blank"><img src="{{$row['image']}}"
                                        class="img-responsive"></a></td>
                            <td><a href="{{$row['url']}}" target="_blank" class="text-black">{{$row['title']}}</a></td>
                            <td>@if (!$scraper_query == null)
                                <a href="{{ asset($settings['app_base']) }}/{{$scraper_query->slug}}" target="_blank"><span
                                        class="btn btn-sm cs-green">@lang('admin.scraper_added')</span></a>
                                @else <a href="{{action('ScraperController@show', $row['id'])}}"><span
                                        class="btn btn-sm bg-maroon">@lang('admin.scraper_not_added')</span></a>
                                @endif</td>
                            <td><a href="{{action('ScraperController@show', $row['id'])}}"
                                    class="btn btn-sm bg-purple"><i class="fas fa-edit"></i> @lang('admin.submit')</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.general form elements -->

        @if($platforms->isEmpty())
        <h6 class="alert alert-danger">@lang('admin.no_record').</h6>
        @endif

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

@endsection