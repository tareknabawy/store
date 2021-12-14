{!!$settings['after_head_tag']!!}

<!-- Header Container -->
<div class="header-container">
    <div class="container">
        <header class="site-header pt-2 pb-2">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-6">
                    <h1 class="site-header-logo"><a href="{{ asset('') }}">@if ($settings['use_text_logo'] == '0')<img src="/images/logo.png" alt="{{$settings['site_title']}}" class="img-fluid">@else{{$settings['site_title']}}@endif</a></h1>
                </div>
                <div class="col-6 d-flex justify-content-end align-items-center">
                    <div class="headersm">

                        @if(auth()->check())
                        <a href="{{route('user.profile')}}" ><i class="fas fa-user"></i></a>
                        @endif
                        @if(!auth()->check())
                        <a href="{{route('register')}}" ><i class="fas fa-user-plus" style="color: #b78b1d;"></i></a>
                        @endif

                        <a href="javascript:void(0);" onclick="SearchBox()"><i class="fas fa-search"></i></a>
                        @if (!empty($settings['facebook_page']))<a href="{{$settings['facebook_page']}}" target="_blank"><i class="fab fa-facebook-f"></i></a>@endif
                        @if (!empty($settings['twitter_account']))<a href="https://www.twitter.com/{{$settings['twitter_account']}}" target="_blank"><i class="fab fa-twitter"></i></a>@endif
                        @if ($settings['random_app_link'] == '1')<a href="{{ asset($settings['app_base'].'/random') }}"><i class="fas fa-random"></i></a>@endif
                        @if (!empty($settings['show_rss_feed']))<a href="{{ asset('rss') }}" target="_blank"><i class="fas fa-rss"></i></a>@endif

                    </div>
                </div>
            </div>
        </header>
    </div>
</div>
<!-- /Header Container -->

<!-- Nav Container -->
<div class="nav-container nav-bg-{{$settings['navbar_color']}}">
    <div class="container">
        <div class="nav-scroller">
            <nav class="nav d-flex">
                <a class="pr-2 pt-2" href="{{ asset('') }}"><i class="fa fa-home"></i> @lang('general.homepage')</a>
                @foreach ($categories as $category)
                @if ($category->navbar == '1')
                <a href="{{ asset($settings['category_base']) }}/{{ $category->slug }}">@if(!empty($category->fa_icon))<i class="{{ $category->fa_icon }}"></i> @endif{{ $category->title }}</a>
                @endif
                @endforeach
            </nav>
        </div>
    </div>
</div>
<!-- /Nav Container -->

<!-- Search Box -->
<div id="SearchBox" class="overlaymenu">
    <a href="javascript:void(0)" class="closebtn" onclick="closeSearchBox()">&times;</a>
    <div class="overlay-content-search">
        <div class="container">
            <form method="post" action="{{ asset('search') }}">
                {{ csrf_field() }}
                <div class="row justify-content-center">
                    <div class="md-form mt-0">
                        <input class="form-control form-control-lg" type="text" name="term" id="term" placeholder="@lang('general.search_apps')" aria-label="@lang('general.search_apps')">
                    </div>
                    <div class="col-auto">
                        <button class="sbtn btn-lg" type="submit">@lang('general.search')</button>
                    </div>
                </div>

                @if (!empty($settings['recommended_terms']))
                @php $terms = explode(",", $settings['recommended_terms']); @endphp
                @if (count($terms) > 0)

                <div class="d-flex justify-content-center">
                <div class="recommended-terms mt-1" id="terms">
                    <strong>@lang('general.recommended_terms')</strong>
                    @foreach ($terms as $term)
                    <a href="#">{{ $term }}</a>
                    @endforeach
                </div>
            </div>

                @endif
                @endif

            </form>
        </div>
    </div>
</div>
<!-- /Search Box -->

@if (!is_null($ad[1]))
@php echo '<div class="container text-center mt-3">'.$ad[1].'</div>'; @endphp
@endif
