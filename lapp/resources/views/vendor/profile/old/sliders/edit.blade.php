@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.edit_slider'))

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
            <form method="POST" enctype="multipart/form-data" action="{{action('SliderController@update', $id)}}">
                @csrf @method('PUT')

                <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>@lang('admin.slider_title') <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{$slider->title}}"
                            placeholder="@lang('admin.slider_title')" />
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.application_name') <span class="text-danger">*</span></label>
                        <select id="@lang('admin.application_name')" name="link" class="form-control selectpicker"
                            data-live-search="true">
                            <option value="">Not Selected</option>
                            @foreach($apps as $app)
                            <option value="{{ $app->id }}" {{ $slider->link == $app->id ? 'selected="selected"' : '' }}>
                                {{ $app->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.image')</label>
                        <input type="file" name="image">
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.active')</label><br />
                        <input type="checkbox" name="active" {{ $slider->active == 1 ? 'checked' : '' }}>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.submit') </button>
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