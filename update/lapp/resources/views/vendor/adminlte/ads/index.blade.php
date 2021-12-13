@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.ads'))

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
                    <table class="table table-striped">
                        <tr>
                            <th class="col-md-1">ID</th>
                            <th class="col-md-9">@lang('admin.ad_location')</th>
                            <th class="col-md-1">@lang('admin.status')</th>
                            <th class="col-md-1">@lang('admin.edit')</th>
                        </tr>
                        @foreach($ads as $row)
                        <tr>
                            <td>{{$row['id']}}</td>
                            <td>@lang('admin.'.$row['title'])</td>
                            @if (empty($row->code))
                            <td><a href="{{action('AdController@edit', $row['id'])}}"
                                    class="btn btn-sm bg-olive">@lang('admin.ad_available')</a></td>
                            @else
                            <td><a href="{{action('AdController@edit', $row['id'])}}"
                                    class="btn btn-sm bg-navy">@lang('admin.ad_in_use')</a></td>
                            @endif
                            <td><a href="{{action('AdController@edit', $row['id'])}}"
                                    class="btn btn-link btn-sm bg-purple"><i class="fas fa-edit"></i>
                                    @lang('admin.edit')</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.general form elements -->

        @if($ads->isEmpty())
        <h6 class="alert alert-danger">@lang('admin.no_record').</h6>
        @endif

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

@endsection