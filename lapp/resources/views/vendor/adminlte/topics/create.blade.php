@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.create_topic'))

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
            <form method="POST" enctype="multipart/form-data" action="{{url('/admin/topics')}}">
                @csrf @method('POST')

                <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>@lang('admin.topic_title') <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control"
                            placeholder="@lang('admin.topic_title')" />
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.app_description')</label>
                        <textarea class="textarea textarea-style" name="description"
                            placeholder="@lang('admin.app_description')"></textarea>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.image') <span class="text-danger">*</span></label>
                        <input type="file" name="image">
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