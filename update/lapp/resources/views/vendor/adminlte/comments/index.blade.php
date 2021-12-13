@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.comments'))

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

                <div class="table-responsive">
                    <table class="table table-striped" id="table" data-delete-prompt="@lang('admin.delete_prompt')" data-yes="@lang('admin.yes')" data-cancel="@lang('admin.cancel')" data-approve="@lang('admin.approve')" data-mark-unapproved="@lang('admin.mark_unapproved')">
                        <tr>
                            <th class="col-md-1">ID</th>
                            <th class="col-md-2">@lang('admin.app_title')</th>
                            <th class="col-md-2">@lang('admin.title')</th>
                            <th class="col-md-2">@lang('admin.name')</th>
                            <th class="col-md-1">@lang('admin.email')</th>
                            <th class="col-md-1">@lang('admin.rating')</th>
                            <th class="col-md-2">@lang('admin.details')</th>
                            <th class="col-md-1">@lang('admin.status')</th>
                            <th class="col-md-1">@lang('admin.delete')</th>
                        </tr>
                        <tbody>
                            @foreach($comments as $row)
                            <tr id="{{ $row->id }}">
                                <td>{{$row->id}}</td>
                                <td><a href="{{ asset($settings['app_base']) }}/{{ $row->app_slug }}" class="text-black" target="_blank">{{$row['app_title']}}</a></td>
                                <td>{{{$row->title}}}</td>
                                <td>{{{$row->name}}}</td>
                                <td>{{{$row->email}}}</td>
                                <td>{{{$row->rating}}}</td>
                                <td>{{\Carbon\Carbon::parse($row->created_at)->translatedFormat('F d, Y H:i:s')}}<br /><strong>@lang('admin.ip_address'):</strong> {{{$row->ip}}}</td>
                                @if ($row->approval == 0)
                                <td><a data-comment-title="{{{$row->title}}}" data-comment-details="{{{$row->comment}}}"
                                        href="{{ asset('') }}{{action('CommentController@edit', $row['id'], '')}}"
                                        class="btn btn-sm bg-orange show_comment_not_approved"><i
                                            class="fas fa-spinner"></i> @lang('admin.pending')</a></td>
                                @else
                                <td><a data-comment-title="{{{$row->title}}}" data-comment-details="{{{$row->comment}}}"
                                        href="{{ asset('') }}{{action('CommentController@edit', $row['id'], '')}}"
                                        class="btn btn-sm bg-olive show_comment_approved"><i class="fas fa-check"></i>
                                        @lang('admin.approved')</a></td>
                                @endif
                                <td>
                                    <form id="delete_from_{{$row->id}}" method="POST"
                                        action="{{action('CommentController@destroy', $row['id'])}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <a href="javascript:void(0);" data-id="{{$row->id}}" class="_delete_data">
                                            <span class="btn btn-sm bg-red"><i class="fas fa-ban"></i> @lang('admin.delete')</span>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.general form elements -->

        @if($comments->isEmpty())
        <h6 class="alert alert-danger">@lang('admin.no_record').</h6>
        @endif

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

{{ $comments->onEachSide(1)->links() }}

@endsection