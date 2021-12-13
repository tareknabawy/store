@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.create_app'))

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
            <form method="POST" enctype="multipart/form-data" action="{{url('/admin/submissions')}}">
                @csrf @method('POST')
                <input type="hidden" name="owner_id" value="{{$submission['user_id']}}">
                <input type="hidden" name="image" value="{{$submission['image']}}" />
                <input type="hidden" name="app_id" value="{{$submission['id']}}" />

                <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>@lang('admin.app_title') <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{{$submission->title}}}" placeholder="@lang('admin.app_title')" />
                    </div>

                    <div class="form-group">
                        <img src="{{ asset('images/submissions/'.$submission->image.'') }}" class="app-image">
                        <label>@lang('admin.image')</label><br />
                        <label class="btn btn-outline btn-sm" id="browse-color-image">@lang('admin.browse')<input type="file" name="different_image" class="hidden"></label>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.app_description') <span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" value="{{$submission->description}}" placeholder="@lang('admin.app_description')" />
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.tags')</label>
                        <input type="text" name="tags" class="form-control" data-role="tagsinput" placeholder="@lang('admin.tags')" />
                    </div>

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_category') <span class="text-danger">*</span></label>
                                <select title="@lang('admin.select_category')" name="category" class="form-control selectpicker" data-live-search="true">
                                    @foreach($categories as $category)
                                    <option data-icon="{{ $category->fa_icon }}" value="{{ $category->id }}" {{ $submission->category == $category->id ? ' selected' : '' }}>
                                        {{ $category->title }}
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
                                    <option data-icon="{{ $platform->fa_icon }}" value="{{ $platform->id }}" {{ $submission->platform == $platform->id ? ' selected' : '' }}>
                                        {{ $platform->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_button_title') <span class="text-danger">*</span></label>
                                <select title="@lang('admin.select_button')" name="type" class="form-control selectpicker" data-live-search="true">
                                    <option data-icon="fas fa-download" value="1">@lang('admin.download_now')</option>
                                    <option data-icon="fas fa-external-link-alt" value="2">
                                        @lang('admin.visit_page')</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.slug')</label>
                                <input type="text" name="slug" class="form-control" placeholder="@lang('admin.slug')" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.custom_meta_description')</label>
                                <input type="text" name="custom_description" class="form-control" placeholder="@lang('admin.custom_meta_description')" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_developer') <span class="text-danger">*</span></label>
                                <input type="text" name="developer" class="form-control" value="{{$submission->developer}}" placeholder="@lang('admin.app_developer')" />
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_license')</label>
                                <input type="text" name="license" class="form-control" value="{{$submission->license}}" placeholder="@lang('admin.app_license')" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_file_size')</label>
                                <input type="text" name="file_size" class="form-control" value="{{$submission->file_size}}" placeholder="@lang('admin.app_file_size')" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_counter') <span class="text-danger">*</span></label>
                                <input type="text" name="counter" class="form-control" value="0" placeholder="@lang('admin.app_counter')" />
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <!-- row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_buy_url')</label>
                                <input type="text" name="buy_url" class="form-control" placeholder="@lang('admin.app_buy_url')" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.app_download_page_url') <span class="text-danger">*</span></label>
                                <input type="text" name="url" class="form-control" value="{{$submission->url}}" placeholder="@lang('admin.app_download_page_url')" />
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
                                <input type="checkbox" name="featured">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('admin.pinned')</label><br />
                                <input type="checkbox" name="pinned">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('admin.editors_choice')</label><br />
                                <input type="checkbox" name="editors_choice">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('admin.must_have')</label><br />
                                <input type="checkbox" name="must_have">
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                    <div class="form-group">
                        <label>@lang('admin.app_detailed_description')</label>
                        <textarea class="textarea textarea-style" name="details" placeholder="@lang('admin.app_detailed_description')">{{$submission->details}}</textarea>
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