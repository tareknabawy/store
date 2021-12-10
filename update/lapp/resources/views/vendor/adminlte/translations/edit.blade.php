@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.edit_translation'))

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

        <!-- general form elements general -->
        <div class="box">

            <!-- form -->
            <form method="POST" id="form_1" enctype="multipart/form-data"
                action="{{action('TranslationController@update', $id)}}">
                @csrf @method('PUT')

                <input name="translation_type" type="hidden" value="1">

                <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>@lang('admin.language') <span class="text-danger">*</span></label>
                        <input type="text" name="language" class="form-control" value="{{$translation->language}}"
                            placeholder="@lang('admin.language')" @if ($translation->code == 'en')readonly @endif/>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.language_code') <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" value="{{$translation->code}}"
                            placeholder="@lang('admin.language_code')" @if ($translation->code == 'en')readonly @endif/>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.og_locale_tag') <span class="text-danger">*</span></label>
                        <input type="text" name="locale_code" class="form-control" value="{{$translation->locale_code}}"
                            placeholder="@lang('admin.og_locale_tag')" />
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.submit')</button>
                </div>

            </form>
            <!-- /.form -->

        </div>
        <!-- /.general form elements general -->

        <h4 class="text-bold mb-2">@lang('admin.frontend')</h4>

        <!-- general form elements frontend -->
        <div class="box">

            <!-- form -->
            <form method="POST" id="form_2" enctype="multipart/form-data"
                action="{{action('TranslationController@update', $id)}}">
                @csrf @method('PUT')

                <input name="translation_type" type="hidden" value="2">

                <!-- box-body -->
                <div class="box-body">

                    @foreach($translation_frontend_org as $key => $item)
                    @if ($loop->first) @continue @endif
                    <div class="form-group">
                        <label>{{$item}}</label>
                        <input type="text" name="{{$key}}" class="form-control"
                            value="{{$translation_frontend_target[$key]}}"
                            placeholder="{{$translation_frontend_target[$key]}}" />
                    </div>
                    @endforeach

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.submit')</button>
                </div>

            </form>
            <!-- /.form -->

        </div>
        <!-- /.general form elements frontend -->

        <h4 class="text-bold mb-2">@lang('admin.dashboard')</h4>

        <!-- general form elements dashboard -->
        <div class="box">

            <!-- form -->
            <form method="POST" id="form_2" enctype="multipart/form-data"
                action="{{action('TranslationController@update', $id)}}">
                @csrf @method('PUT')

                <input name="translation_type" type="hidden" value="3">

                <!-- box-body -->
                <div class="box-body">

                    @foreach($translation_admin_org as $key => $item)
                    @if ($loop->first) @continue @endif
                    <div class="form-group">
                        <label>{{$item}}</label>
                        <input type="text" name="{{$key}}" class="form-control"
                            value="{{$translation_admin_target[$key]}}"
                            placeholder="{{$translation_admin_target[$key]}}" />
                    </div>
                    @endforeach


                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.submit')</button>
                </div>

            </form>
            <!-- /.form -->

        </div>
        <!-- /.general form elements dashboard -->
    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

@endsection