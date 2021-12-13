@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.settings'))

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

            <!-- form -->
            <form method="POST" enctype="multipart/form-data" action="{{url('/admin/settings')}}">
                @csrf @method('POST')

                <!-- box-body -->
                <div class="box-body">

                    @foreach ($settings as $setting)
                    @php $setting_data[$setting->name]=$setting->value; @endphp
                    @endforeach

                    <div class="form-group">
                        <label>@lang('admin.site_title')</label>
                        <input type="text" name="site_title" class="form-control" value="{{$setting_data['site_title']}}" placeholder="@lang('admin.site_title')" />
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.site_description')</label>
                        <input type="text" name="site_description" class="form-control" value="{{$setting_data['site_description']}}" placeholder="@lang('admin.site_description')" />
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.site_logo')</label>
                        <img src="/images/logo.png?r={{Str::random(40)}}" class="img-responsive image_preview">
                        <input type="file" name="site_logo">
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.use_text_logo') </label><br />
                        <input type="checkbox" name="use_text_logo" {{ $setting_data['use_text_logo'] == 1 ? 'checked' : '' }}>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('admin.site_language')</label>
                                <select title="@lang('admin.site_language')" name="site_language" class="form-control selectpicker" data-live-search="true">
                                    @foreach($language_translation as $lang => $language)
                                    <option value="{{ $lang }}" {{ $setting_data['site_language'] == $lang ? ' selected' : '' }}>{{ $language }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('admin.navbar_color')</label>
                                <select title="@lang('admin.navbar_color')" name="navbar_color" class="form-control selectpicker" data-live-search="true">
                                    @foreach($navbar_colors as $lang => $language)
                                    <option value="{{ $lang }}" {{ $setting_data['navbar_color'] == $lang ? ' selected' : '' }}>
                                        {{ $language }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('admin.facebook_page_url')</label>
                                <input type="text" name="facebook_page" class="form-control" value="{{$setting_data['facebook_page']}}" placeholder="@lang('admin.facebook_page_url')" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('admin.twitter_account_url')</label>
                                <input type="text" name="twitter_account" class="form-control" value="{{$setting_data['twitter_account']}}" placeholder="@lang('admin.twitter_account_url')" />
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>@lang('admin.screenshot_count')</label>
                                <input type="text" name="screenshot_count" class="form-control" value="{{$setting_data['screenshot_count']}}" placeholder="@lang('admin.screenshot_count')" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('admin.time_before_redirect')</label>
                                <input type="text" name="time_before_redirect" class="form-control" value="{{$setting_data['time_before_redirect']}}" placeholder="@lang('admin.time_before_redirect')" />
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label>@lang('admin.favicon')</label>
                        <img src="/images/favicon.png?r={{Str::random(40)}}" class="img-responsive image_preview">
                        <input type="file" name="favicon">
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.default_app_image') <span class="label label-success">200x200</span></label>
                        <img src="/images/no_image.png?r={{Str::random(40)}}" class="img-responsive image_preview">
                        <input type="file" name="default_app_image">
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.default_share_image') <span class="label label-success">600x315</span></label>
                        <img src="/images/default_share_image.png?r={{Str::random(40)}}" class="img-responsive image_preview">
                        <input type="file" name="default_share_image">
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.html_code_before_head')</label>
                        <textarea class="form-control" name="before_head_tag" rows="3">{{$setting_data['before_head_tag']}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.html_code_after_body')</label>
                        <textarea class="form-control" name="after_head_tag" rows="3">{{$setting_data['after_head_tag']}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.html_code_before_body_end')</label>
                        <textarea class="form-control" name="before_body_end_tag" rows="3">{{$setting_data['before_body_end_tag']}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.auto_submission_crontab_link') <a href="?generate=submission_crontab"><u>@lang('admin.generate_another_link')</u></a></label>
                        <input type="text" class="form-control" value="{{request()->getSchemeAndHttpHost()}}/crawler/{{$setting_data['submission_crontab_code']}}" placeholder="@lang('admin.auto_submission_crontab_link')" readonly />
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.crontab_link') <a href="?generate=crontab"><u>@lang('admin.generate_another_link')</u></a></label>
                        <input type="text" class="form-control" value="{{request()->getSchemeAndHttpHost()}}/crontab/{{$setting_data['crontab_code']}}" placeholder="@lang('admin.crontab_link')" readonly />
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.hourly_crontab_link') <a href="?generate=hourly-crontab"><u>@lang('admin.generate_another_link')</u></a></label>
                        <input type="text" class="form-control" value="{{request()->getSchemeAndHttpHost()}}/hourly-crontab/{{$setting_data['hourly_crontab_code']}}" placeholder="@lang('admin.hourly_crontab_link')" readonly />
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.recommended_terms')</label>
                        <input type="text" name="recommended_terms" class="form-control" data-role="tagsinput" placeholder="Tags" value="{{$setting_data['recommended_terms']}}" />
                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>@lang('admin.google_play_country')</label>
                                <input type="text" name="google_play_default_country" class="form-control" value="{{$setting_data['google_play_default_country']}}" placeholder="@lang('admin.google_play_default_country')" />
                            </div>
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>@lang('admin.google_play_language')</label>
                                <input type="text" name="google_play_default_language" class="form-control" value="{{$setting_data['google_play_default_language']}}" placeholder="@lang('admin.google_play_default_language')" />
                            </div>
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>@lang('admin.schema_org_price_currency')</label>
                                <input type="text" name="schema_org_price_currency" class="form-control" value="{{$setting_data['schema_org_price_currency']}}" placeholder="@lang('admin.schema_org_price_currency')" />
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.enable_cache')</label><br />
                                <input type="checkbox" name="enable_cache" {{ $setting_data['enable_cache'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.auto_submission')</label><br />
                                <input type="checkbox" name="auto_submission" {{ $setting_data['auto_submission'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.ping_google')</label><br />
                                <input type="checkbox" name="ping_google" {{ $setting_data['ping_google'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.auto_comment_approval')</label><br />
                                <input type="checkbox" name="auto_comment_approval" {{ $setting_data['auto_comment_approval'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.show_cookie_bar')</label><br />
                                <input type="checkbox" name="show_cookie_bar" {{ $setting_data['show_cookie_bar'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.cloudflare_ip')</label><br />
                                <input type="checkbox" name="cloudflare_ip" {{ $setting_data['cloudflare_ip'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.breadcrumbs') </label><br />
                                <input type="checkbox" name="breadcrumbs" {{ $setting_data['breadcrumbs'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.schema_breadcrumbs')</label><br />
                                <input type="checkbox" name="schema_breadcrumbs" {{ $setting_data['schema_breadcrumbs'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.show_submission_form')</label><br />
                                <input type="checkbox" name="show_submission_form" {{ $setting_data['show_submission_form'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.reading_time')</label><br />
                                <input type="checkbox" name="reading_time" {{ $setting_data['reading_time'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.rss_link')</label><br />
                                <input type="checkbox" name="show_rss_feed" {{ $setting_data['show_rss_feed'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('admin.random_app_link') </label><br />
                                <input type="checkbox" name="random_app_link" {{ $setting_data['random_app_link'] == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

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