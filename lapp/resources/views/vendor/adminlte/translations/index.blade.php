@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.translations'))

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        @if($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
        @endif

        @if($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{$message}}</p>
        </div>
        @endif

        <!-- general form elements -->
        <div class="box">

            <!-- box-body -->
            <div class="box-body no-padding">

                <a href="/admin/translations/create" class="btn bg-purple btn-flat margin"><i
                        class="fas fa-plus-square"></i> @lang('admin.create_translation')</a>
                <div class="table-responsive">
                    <table class="table table-striped" id="table" data-delete-prompt="@lang('admin.delete_prompt')"
                        data-yes="@lang('admin.yes')" data-cancel="@lang('admin.cancel')"
                        data-mark-unapproved="@lang('admin.mark_unapproved')">
                        <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-8">@lang('admin.language')</th>
                                <th class="col-md-1">@lang('admin.edit')</th>
                                <th class="col-md-1">@lang('admin.delete')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($translations as $row)
                            <tr id="{{ $row->id }}">
                                <td>{{$row->id}}</td>
                                <td>{{$row->language}}</td>
                                <td><a href="{{action('TranslationController@edit', $row->id)}}"
                                        class="btn btn-link btn-sm bg-purple"><i class="fas fa-edit"></i>
                                        @lang('admin.edit')
                                    </a></td>
                                <td>
                                    <form id="delete_from_{{$row->id}}" method="POST"
                                        action="{{action('TranslationController@destroy', $row['id'])}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        @if($row->id == '1')
                                        <a href="javascript:void(0);">
                                            <span class="btn btn-sm bg-red disabled"> <i
                                                    class="fas fa-ban"></i>@lang('admin.delete')</span>
                                            @else
                                            <a href="javascript:void(0);" data-id="{{$row->id}}" class="_delete_data">
                                                <span class="btn btn-sm bg-red"> <i
                                                        class="fas fa-ban"></i>@lang('admin.delete')</span>
                                                @endif
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

        @if($translations->isEmpty())
        <h6 class="alert alert-danger">@lang('admin.no_record').</h6>
        @endif

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

@endsection