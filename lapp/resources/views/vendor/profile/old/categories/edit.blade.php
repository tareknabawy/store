@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.edit_category'))

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
            <form method="POST" enctype="multipart/form-data" action="{{action('CategoryController@update', $id)}}">
            @csrf @method('PUT')

            <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>@lang('admin.category_title') <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{$category->title}}"
                               placeholder="@lang('admin.category_title')"/>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.custom_meta_description')</label>
                        <textarea class="form-control" name="description" rows="3"
                            placeholder="@lang('admin.custom_meta_description')">{{$category->description}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.category_icon')</label>
                        <select id="@lang('admin.select_icon')" name="fa_icon" class="form-control selectpicker" data-live-search="true">
                            <option value="">@lang('admin.no_icon')</option>
                        @foreach($icons as $icon)
                                <option data-icon="{{ $icon->icon }}" value="{{ $icon->icon }}" {{ $category->fa_icon == $icon->icon ? 'selected="selected"' : '' }}>{{ $icon->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Schema.org applicationCategory</label>

                        <select title="Schema.org applicationCategory" name="application_category" class="form-control selectpicker"
                                data-live-search="true">
                            @foreach($applicationcategories as $cat_id => $cat_title)
                                <option
                                    value="{{ $cat_id }}" {{ $category->application_category == $cat_id ? 'selected="selected"' : '' }}>{{ $cat_title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.show_in_navbar') </label><br/>
                        <input type="checkbox" name="navbar" {{ $category->navbar == 1 ? 'checked' : '' }}>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.show_in_footer')</label><br/>
                        <input type="checkbox" name="footer" {{ $category->footer == 1 ? 'checked' : '' }}>
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
