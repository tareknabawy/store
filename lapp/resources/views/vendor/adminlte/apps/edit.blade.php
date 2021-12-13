@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.edit_application'))

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        @if(count($errors) > 0)
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <p>{{$error}}</p>
            @endforeach
        </div>
        @endif @if(Session::has('success'))
        <div class="alert alert-success">
            <p>{{ Session::get('success') }}</p>
        </div>
        @endif

        <!-- general form elements -->
        <div class="box">

            <!-- form -->
            <form method="POST" enctype="multipart/form-data" action="{{action('ApplicationController@update', $id)}}">
                @csrf @method('PUT')

                <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>@lang('admin.app_title') <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{$app->title}}" placeholder="@lang('admin.app_title')" />
                    </div>

                    <div class="form-group">
                        <img src="@if(empty($app->image)){{ asset('images/no_image.png') }}@else{{ asset('images') }}/{{ $app->image }}@endif" class="app-image">
                        <label>@lang('admin.image')</label><br />
                        <label class="btn btn-outline btn-sm" id="browse-color-image">@lang('admin.browse')<input type="file" name="image" class="hidden"></label>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.app_description') <span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" value="{{$app->description}}" placeholder="@lang('admin.app_description')" />
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.tags')</label>
                        <input type="text" name="tags" class="form-control" data-role="tagsinput" value="@foreach($app->tags as $tag){{ $tag->name }}@if (!$loop->last),@endif @endforeach" placeholder="@lang('admin.tags')" />
                    </div>

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_category') <span class="text-danger">*</span></label>
                                <select title="@lang('admin.select_category')" name="category" class="form-control selectpicker" data-live-search="true">
                                    @foreach($categories as $category)
                                    <option data-icon="{{ $category->fa_icon }}" value="{{ $category->id }}" {{ $app->category == $category->id ? ' selected' : '' }}>{{ $category->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_platform') <span class="text-danger">*</span></label>
                                <select title="@lang('admin.select_platform')" name="platform" class="form-control selectpicker" data-live-search="true">
                                    @foreach($platforms as $platform)
                                    <option data-icon="{{ $platform->fa_icon }}" value="{{ $platform->id }}" {{ $app->platform == $platform->id ? ' selected' : '' }}>{{ $platform->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_button_title') <span class="text-danger">*</span></label>
                                <select title="@lang('admin.select_button')" name="type" class="form-control selectpicker" data-live-search="true">
                                    <option data-icon="fas fa-download" value="1" {{ $app->type == 1 ? ' selected' : '' }}>@lang('admin.download_now')
                                    </option>
                                    <option data-icon="fas fa-external-link-alt" value="2" {{ $app->type == 2 ? ' selected' : '' }}>@lang('admin.visit_page')
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.slug') <span class="text-danger">*</span></label>
                                <input type="text" name="slug" class="form-control" value="{{$app->slug}}" placeholder="@lang('admin.slug')" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.custom_meta_description')</label>
                                <input type="text" name="custom_description" class="form-control" value="{{$app->custom_description}}" placeholder="@lang('admin.custom_meta_description')" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_developer') <span class="text-danger">*</span></label>
                                <input type="text" name="developer" class="form-control" value="{{$app->developer}}" placeholder="Developer" />
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_license')</label>
                                <input type="text" name="license" class="form-control" value="{{$app->license}}" placeholder="License" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_file_size')</label>
                                <input type="text" name="file_size" class="form-control" value="{{$app->file_size}}" placeholder="File Size" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_counter') <span class="text-danger">*</span></label>
                                <input type="text" name="counter" class="form-control" value="{{$app->counter}}" placeholder="Download Counter" />
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_buy_url')</label>
                                <input type="text" name="buy_url" class="form-control" value="{{$app->buy_url}}" placeholder="@lang('admin.app_buy_url')" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_download_page_url') <span class="text-danger">*</span></label>
                                <input type="text" name="url" class="form-control" value="{{$app->url}}" placeholder="Download/Page URL" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>File</label><br />
                                <label class="btn btn-outline btn-sm" id="browse-color-file">@lang('admin.browse')<input type="file" name="file" id="import-file-select" class="hidden"></label>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('admin.featured')</label><br />
                                <input type="checkbox" name="featured" {{ $app->featured == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('admin.pinned')</label><br />
                                <input type="checkbox" name="pinned" {{ $app->pinned == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('admin.editors_choice')</label><br />
                                <input type="checkbox" name="editors_choice" {{ $app->editors_choice == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('admin.must_have')</label><br />
                                <input type="checkbox" name="must_have" {{ $app->must_have == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">


                    </div>
                    <!-- /.row -->

                    <div class="form-group">
                        <label>@lang('admin.app_detailed_description')</label>
                        <textarea class="textarea textarea-style" name="details" placeholder="@lang('admin.app_detailed_description')">{{$app->details}}</textarea>
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

<!-- general form elements -->
<div class="box">

    <!-- box-body -->
    <div class="box-body" id="screenshots" data-content-deleted="@lang('admin.content_deleted')" data-succesfully-deleted="@lang('admin.content_succesfully_deleted')">

        <form method="post" action="{{ route('upload', ['app_id'=>$app->id]) }}" id="screenshot_form" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>@lang('admin.screenshots')</label><br />
                <label class="btn btn-outline btn-sm" id="browse-color-image">@lang('admin.browse')<input type="file" name="file[]" id="file" accept="image/*" class="hidden" multiple /></label>
            </div>

                <input type="submit" name="upload" value="@lang('admin.upload')" class="btn btn-primary mb-10" />
        </form>

        <div class="progress">
            <div class="progress-bar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                0%
            </div>
        </div>

        <div id="success" class="row">
            @php
            if ($app->screenshots != "") {

            $mysplit = explode(',', $app->screenshots);
            $screenshot_data = array_reverse($mysplit);

            $image_code_s = '';
            foreach($screenshot_data as $screenshot) {
            $image_code_s .= '<div class="col-md-2 mb-10 text-center"><img src="/screenshots/'.$screenshot.'" class="img-thumbnail" /><button type="button" data-name="'.$screenshot.'" data-app-id="'.$app->id.'" class="btn btn-danger mt-10 remove_screenshot">' . __('admin.delete') . '</button></div>';
            }
            echo $image_code_s;
            } else {
            echo '<div class="text-center"><b>' . __('admin.no_screenshots_yet') . '</b></div><br />';
            }
            @endphp
        </div>

    </div>
    <!-- /.box -->

</div>
<!-- /.general form elements -->

@endsection