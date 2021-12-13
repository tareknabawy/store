@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.topics'))

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

                <a href="{{ asset('/admin/topics/create') }}" class="btn bg-purple btn-flat margin"><i
                        class="fas fa-plus-square"></i> @lang('admin.create_topic')</a>
                <div class="table-responsive">
                <table class="table table-striped" id="table" data-delete-prompt="@lang('admin.delete_prompt')" data-yes="@lang('admin.yes')" data-cancel="@lang('admin.cancel')" data-mark-unapproved="@lang('admin.mark_unapproved')">
                        <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-7">@lang('admin.title')</th>
                                <th class="col-md-1">@lang('admin.items')</th>
                                <th class="col-md-1">@lang('admin.edit')</th>
                                <th class="col-md-1">@lang('admin.delete')</th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach($topics as $row)
                            <tr id="{{ $row->id }}">
                                <td>{{$row->id}}</td>
                                <td><a href="{{ asset($settings['topic_base']) }}/{{ $row->slug }}" class="text-black" target="_blank">{{$row->title}}</a></td>
                                <td><a href="{{ asset("/admin/topic/$row->id") }}"
                                    class="btn btn-link btn-sm bg-maroon"><i class="fas fa-star"></i>
                                    Items
                                </a></td>
                                <td><a href="{{action('TopicController@edit', $row->id)}}"
                                        class="btn btn-link btn-sm bg-purple"><i class="fas fa-edit"></i>
                                        @lang('admin.edit')
                                    </a></td>
                                <td>
                                    <form id="delete_from_{{$row->id}}" method="POST"
                                        action="{{action('TopicController@destroy', $row['id'])}}">
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
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.general form elements -->

        @if($topics->isEmpty())
        <h6 class="alert alert-danger">@lang('admin.no_record').</h6>
        @endif

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

{{ $topics->onEachSide(1)->links() }}

@endsection