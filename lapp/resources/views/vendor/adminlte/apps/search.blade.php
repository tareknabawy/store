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

        @foreach ($platforms as $platform)
        @php $platform_title[$platform->id]=$platform->title; @endphp
        @endforeach

        @foreach ($categories as $category)
        @php $category_title[$category->id]=$category->title; @endphp
        @endforeach

        <!-- general form elements -->
        <div class="box">

            <!-- box-body -->
            <div class="box-body no-padding">

                <a href="/admin/apps/create" class="btn bg-purple btn-flat margin"><i class="fas fa-plus-square"></i>
                    @lang('admin.create_app')</a>
                <div class="table-responsive">
                <table class="table table-striped" id="table" data-delete-prompt="@lang('admin.delete_prompt')" data-yes="@lang('admin.yes')" data-cancel="@lang('admin.cancel')" data-mark-unapproved="@lang('admin.mark_unapproved')">
                        <tr>
                            <th class="col-md-1">ID</th>
                            <th class="col-md-9">@lang('admin.title')</th>
                            <th class="col-md-1">@lang('admin.category')</th>
                            <th class="col-md-1">@lang('admin.platform')</th>
                            <th class="col-md-1">@lang('admin.edit')</th>
                            <th class="col-md-1">@lang('admin.delete')</th>
                        </tr>
                        @foreach($apps as $row)
                        <tr>
                            <td>{{$row['id']}}</td>
                            <td><a href="{{ asset($settings['app_base']) }}/{{ $row->slug }}" class="text-black" target="_blank">{{$row['title']}}</a></td>
                            <td>{{ $category_title[$row->category] }}</td>
                            <td>{{ $platform_title[$row->platform] }}</td>
                            <td><a href="{{action('ApplicationController@edit', $row['id'])}}"
                                    class="btn btn-sm bg-purple"><i class="fas fa-edit"></i> Edit</a></td>
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

{{ $apps->appends(Request::except('page'))->onEachSide(1)->links() }}

@endsection