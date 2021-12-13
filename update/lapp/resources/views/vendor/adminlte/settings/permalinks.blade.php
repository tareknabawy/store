@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.permalinks'))

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
            <form method="POST" enctype="multipart/form-data" action="{{url('/admin/permalinks')}}">
                @csrf @method('POST')

                <!-- box-body -->
                <div class="box-body">

                    @foreach ($settings as $setting)
                    @php $setting_data[$setting->name]=$setting->value; @endphp
                    @endforeach

                        <div class="form-group">
                            <label>@lang('admin.app_base') <span class="text-danger">*</span></label>
                            <input type="text" name="app_base" class="form-control"
                                   value="{{$setting_data['app_base']}}" placeholder="@lang('admin.app_base')" />
                        </div>

                        <div class="form-group">
                            <label>@lang('admin.news_base') <span class="text-danger">*</span></label>
                            <input type="text" name="news_base" class="form-control"
                                   value="{{$setting_data['news_base']}}" placeholder="@lang('admin.news_base')" />
                        </div>

                        <div class="form-group">
                            <label>@lang('admin.category_base') <span class="text-danger">*</span></label>
                            <input type="text" name="category_base" class="form-control"
                                   value="{{$setting_data['category_base']}}" placeholder="@lang('admin.category_base')" />
                        </div>

                        <div class="form-group">
                            <label>@lang('admin.platform_base') <span class="text-danger">*</span></label>
                            <input type="text" name="platform_base" class="form-control"
                                   value="{{$setting_data['platform_base']}}" placeholder="@lang('admin.platform_base')" />
                        </div>

                        <div class="form-group">
                            <label>@lang('admin.page_base') <span class="text-danger">*</span></label>
                            <input type="text" name="page_base" class="form-control"
                                   value="{{$setting_data['page_base']}}" placeholder="@lang('admin.page_base')" />
                        </div>

                        <div class="form-group">
                            <label>@lang('admin.topic_base') <span class="text-danger">*</span></label>
                            <input type="text" name="topic_base" class="form-control"
                                   value="{{$setting_data['topic_base']}}" placeholder="@lang('admin.topic_base')" />
                        </div>

                        <div class="form-group">
                            <label>@lang('admin.tag_base') <span class="text-danger">*</span></label>
                            <input type="text" name="tag_base" class="form-control"
                                   value="{{$setting_data['tag_base']}}" placeholder="@lang('admin.tag_base')" />
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