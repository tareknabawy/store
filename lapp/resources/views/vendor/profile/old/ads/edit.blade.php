@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.edit_ads'))

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif @if(Session::has('success'))
            <div class="alert alert-success">
                <p>{{ Session::get('success') }}</p>
            </div>
    @endif

    <!-- general form elements -->
        <div class="box">

            <!-- form -->
            <form method="POST" enctype="multipart/form-data" action="{{action('AdController@update', $id)}}">
            @csrf @method('PUT')

            <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>@lang('admin.ad_location')</label>
                        <input type="text" name="title" class="form-control" value="@lang('admin.'.$ad['title'])"
                               placeholder="Ad Location" readonly/>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.html_code')</label>
                        <textarea class="form-control" name="code" rows="10" cols="100"
                                  placeholder="@lang('admin.html_code')">{{$ad->code}}</textarea>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.submit')</button>
                </div>

            </form>
            <!-- /.form -->

        </div>
            <!-- /.general form elements -->

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

@endsection
