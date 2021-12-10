@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.submissions'))

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

                <div class="table-responsive">
                <table class="table table-striped" id="table" data-delete-prompt="@lang('admin.delete_prompt')" data-yes="@lang('admin.yes')" data-cancel="@lang('admin.cancel')" data-mark-unapproved="@lang('admin.mark_unapproved')">
                        <tr>
                            <th class="col-md-1">ID</th>
                            <th class="col-md-3">@lang('admin.app_title')</th>
                            <th class="col-md-2">@lang('admin.name')</th>
                            <th class="col-md-2">@lang('admin.email')</th>
                            <th class="col-md-2">@lang('admin.details')</th>
                            <th class="col-md-1">@lang('admin.submit')</th>
                            <th class="col-md-1">@lang('admin.delete')</th>
                        </tr>
                        @foreach($submissions as $row)
                        <tr>
                            <td>{{$row['id']}}</td>
                            <td>{{$row['title']}}</td>
                            <td>{{$row['name']}}</td>
                            <td>{{$row['email']}}</td>
                            <td>{{\Carbon\Carbon::parse($row->created_at)->translatedFormat('F d, Y H:i:s')}}<br /><strong>@lang('admin.ip_address'):</strong> {{$row['ip']}}</td>
                            <td><a href="{{action('SubmissionController@show', $row['id'])}}"
                                    class="btn btn-sm bg-purple"><i class="fas fa-edit"></i> @lang('admin.submit')</a>
                            </td>
                            <td>
                                <form id="delete_from_{{$row->id}}" method="POST"
                                    action="{{action('SubmissionController@destroy', $row['id'])}}">
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

        @if($submissions->isEmpty())
        <h6 class="alert alert-danger">@lang('admin.no_record').</h6>
        @endif

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

{{ $submissions->onEachSide(1)->links() }}

@endsection