@extends('frontend::page')

@section('content')

<!-- Big Container -->
<div class="big-container mt-3">

    <!-- Container -->
    <div class="container">

        <!-- Grid row -->
        <div class="row">

            <!-- Grid column -->
            <div class="col-md-8 mb-3">

                @if (!is_null($ad[5]))<div class="mb-3">{!! $ad[5] !!}</div>@endif

                @if ($settings['breadcrumbs'] == '1')
                <div class="breadcrumbs mb-3">
                    <a href="{{ asset('') }}">@lang('general.homepage')</a> » <a href="{{url()->current()}}">@lang('general.submit_your_app')</a>
                </div>

                @if ($settings['schema_breadcrumbs'] == '1')
                {!! str_replace('\\', '', $breadcrumb_schema_data->toScript()) !!}
                @endif
                @endif
                

                <div class="submission-box" id="submission-section" data-fill-all-fields="@lang('general.fill_all_fields')">

                    <form id="submission-form" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="name">@lang('general.your_name'): <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">@lang('general.your_email'): <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <small id="emailHelp" class="form-text text-muted">@lang('general.email_notification')</small>
                        </div>

                        <div class="form-group">
                            <label for="title">@lang('general.title'): <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="description">@lang('general.description'): <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>

                        <div class="form-group">
                            <label for="category">@lang('general.category'): <span class="text-danger">*</span></label>
                            <select id="category" name="category" class="form-control">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="platform">@lang('general.platform'): <span class="text-danger">*</span></label>
                            <select id="platform" name="platform" class="form-control">
                                @foreach($platforms as $platform)
                                <option value="{{ $platform->id }}">
                                    {{ $platform->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="developer">@lang('general.developer'): <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="developer" name="developer" required>
                        </div>

                        <div class="form-group">
                            <label for="url">@lang('general.download_page_url'): <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="url" name="url" required>
                        </div>

                        <div class="form-group">
                            <label for="license">@lang('general.license'): </label>
                            <input type="text" class="form-control" id="license" name="license">
                        </div>

                        <div class="form-group">
                            <label for="file_size">@lang('general.file_size'):</label>
                            <input type="text" class="form-control" id="file_size" name="file_size">
                        </div>

                        <div class="form-group">
                            <label for="detailed_description">@lang('general.detailed_description'):</label>
                            <textarea class="form-control" rows="5" id="detailed_description" name="detailed_description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">@lang('general.image'): <span class="text-danger">*</span></label>
                            <input type="file" accept="image/*" class="form-control-file" id="image" name="image">
                        </div>

                    </form>

                    <button type="submit" class="btn m-0 comment-button" onclick="submission_form_control()">@lang('general.submit')</button>

                    <div id="submission_result">
                        <div class="alert alert-warning show mt-3 mb-0" role="alert">
                            @lang('general.submission_note')</div>
                    </div>

                </div>


                @if (!is_null($ad[6]))<div class="mt-3">{!! $ad[6] !!}</div>@endif

            </div>
            <!-- /Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 bl-1 mb-3">
                @if (!is_null($ad[3]))<div class="mt-3">{!! $ad[3] !!}</div>@endif
                @include('frontend::inc.top', ['type' => '1'])
                @if (!is_null($ad[4]))<div class="mt-3">{!! $ad[4] !!}</div>@endif
            </div>
            <!-- /Grid column -->

        </div>
        <!-- /Grid row -->

    </div>
    <!-- /Container -->

</div>
<!-- /Big Container -->

@endsection