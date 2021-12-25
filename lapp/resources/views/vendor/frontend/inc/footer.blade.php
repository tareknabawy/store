@if (!is_null($ad[2]))
@php echo '<div class="container text-center mb-3">'.$ad[2].'</div>'; @endphp
@endif
<!-- Footer Container -->
<div class="footer-container">
<!-- Footer -->
<footer class="page-footer">
<!-- Footer Links -->
<div class="container">
<!-- Grid row -->
<div class="row">
<!-- Grid column -->
                <div class="col-md-3 mx-auto">
                    <strong>{{$settings['site_title']}}</strong><br /><br />
                    {{$settings['site_description']}}<br /><br />
                    @if ($settings['show_submission_form'] == '1')
                    
                    
<a href="{{auth()->check()?route('user.submit-app'):route('register')}}" class="btn btn-primary px-3 px-lg-4" class="submit-app" style="font-size: 12px;padding: 6px 20px;margin-top: 0px!important"> <span class="fas fa-upload"></span> Submit App </a><br /><br />
                    
                    
                    @endif
                    @if (!empty($settings['facebook_page']))<a href="{{$settings['facebook_page']}}" target="_blank"><i class="fab fa-facebook-f"></i></a>@endif
                    @if (!empty($settings['twitter_account']))<a href="{{$settings['twitter_account']}}" target="_blank"><i class="fab fa-twitter"></i></a>@endif
                    <a href="https://www.youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a href="https://t.me/apkstoretv" target="_blank"><i class="fab fa-telegram"></i></a>
                </div>
                <!-- /Grid column -->

                <div class="clearfix w-100 d-md-none">&nbsp;</div>

                <!-- Grid column -->
                <div class="col-md-3 col-4">
                    <a class="font-weight-bold">@lang('general.pages')</a><br /><br />
                    <ul class="list-unstyled">
                        @foreach ($pages as $page)
                        <li><a href="{{ asset($settings['page_base']) }}/{{ $page->slug }}">{{ $page->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- /Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-4">
                    <a class="font-weight-bold">@lang('general.categories')</a><br /><br />
                    <ul class="list-unstyled">
                        @foreach ($categories as $category)
                        @if ($category->footer == '1')
                        <li><a href="{{ asset($settings['category_base']) }}/{{ $category->slug }}">{{ $category->title }}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                <!-- /Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-4">
                    <a class="font-weight-bold mt-3 mb-4">@lang('general.platforms')</a><br /><br />
                    <ul class="list-unstyled">
                        @foreach ($platforms as $platform)
                        <li><a href="{{ asset($settings['platform_base']) }}/{{ $platform->slug }}">{{ $platform->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- /Grid column -->

            </div>
            <!-- /Grid row -->

        </div>
        <!-- /Footer Links -->

        <!-- Copyright Message -->
        <div class="footer-copyright text-center py-2"> @lang('general.copyright') © {{date('Y')}} -
        
            <a href="#"> {{$settings['site_title']}}</a>
        </div>
        <!-- /Copyright Message -->

    </footer>
    <!-- /Footer -->

</div>
<!-- /Footer Container -->

@if ($settings['show_cookie_bar'] == '1')
<!-- Cookie Alert -->
<div class="alert text-center cookiealert" role="alert">
    @lang('general.cookies_note')
    <button type="button" class="btn btn-sm acceptcookies" aria-label="Close">
        @lang('general.accept_cookies')
    </button>
</div>
<!-- /Cookie Alert -->
@endif

{!!$settings['before_body_end_tag']!!}

@stack('assets_footer')

<!-- Other JS -->
<script src="{{ asset('js/scripts.js') }}?v1.4"></script>

<!-- Bootstrap -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<!-- Cookie Alert -->
<script src="{{ asset('js/cookiealert.js') }}"></script>
