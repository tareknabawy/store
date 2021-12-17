@extends('frontend::page')

@push('assets_header')
<!-- Swiper CSS -->
<link href="{{ asset('css/swiper.min.css') }}" rel="stylesheet">
@endpush

@push('assets_footer')
<!-- Swiper JS -->
<script src="{{ asset('js/swiper.min.js') }}"></script>
@endpush

@section('content')

<!-- Big Container -->
<div class="big-container mt-3">

    <!-- Container -->
    <div class="container">

        <!-- Grid row -->
        <div class="row">

            <!-- Grid column -->
            <div class="col-md-8 mb-3">

                @foreach ($categories as $category)
                @php $category_name[$category->id]=$category->title; @endphp
                @endforeach

                @if (!is_null($ad[5]))
                <div class="mb-3">{!! $ad[5] !!}</div>@endif

                @if (count($sliders) > 0)
                <!-- Main Slider -->
                <div class="swiper-container swiper-main">
                    <div class="swiper-wrapper">
                        @foreach ($sliders as $slider)

                        <div class="swiper-slide">
                            <a href="{{ asset($settings['app_base']) }}/{{ $slider->slug }}">
                                <div class="coverbg"></div>
                                <h3>{{ $slider->title}}</h3>
                                <img src="{{ asset('images') }}/sliders/{{ $slider->image}}" alt="{{ $slider->title}}">
                            </a>
                        </div>
                        @endforeach

                    </div>
                    <div class="swiper-button-next swiper-button-white"></div>
                    <div class="swiper-button-prev swiper-button-white"></div>
                </div>
                <div class="swiper-pagination-main mt-3 mb-3"></div>
                <!-- /Main Slider -->
                @endif

                @if (!is_null($ad[9]))<div class="mb-3 mt-3">{!! $ad[9] !!}</div>@endif

                @if (count($apps) > 0)
                <!-- New Apps -->
                <div class="d-flex top-title justify-content-between mb-3 mt-3">
                    <div>@lang('general.new_apps')</div>
                    <div><a href="{{ asset('new-apps') }}">@lang('general.more') »</a></div>
                </div>

                <div class="row apps mb-1">
                    @foreach ($apps as $app)

                    @if(empty($app->image))
                    @php $app->image='no_image.png'; @endphp
                    @endif

                    <div class="col-4 mb-2">
                  
                  <div class="d-flex flex-sm-row flex-column app-box" style="position: relative;overflow: hidden;">
                            <div style="position:absolute; right: -150px;top: 0px;transition: .3s all ease-in-out;" class="download-btn">
                                <a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}" class="btn btn-primary btn-sm" style="font-size:14px;padding: 10px  23px;">Download</a>
                            </div>          
                          
                            
                            <div class="pr-2 mb-1"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}"><img src="{{ asset('images') }}/{{ $app->image }}" class="image rounded" alt="{{ $app->title }}"></a></div>
                            <div class="box"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}"
                                    class="title">{{ $app->title }}</a>

                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++) @if($i<=round($app->votes))
                                        <span class="fa fa-star checked"></span>
                                        @else
                                        <span class="fa fa-star"></span>
                                        @endif
                                        @endfor
                                </div>

                                <span
                                    class="category">{{\Carbon\Carbon::parse($app->created_at)->translatedFormat('M d, Y')}}</span>
                                <span class="license">{{ $app->license }}</span>

                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <!-- /New Apps -->
                @endif

                @if (!is_null($ad[10]))<div class="mb-3 mt-1">{!! $ad[10] !!}</div>@endif

                @if (count($latest_news) > 0)
                <!-- Tech News -->
                <div class="d-flex top-title justify-content-between mb-3">
                    <div>@lang('general.tech_news')</div>
                    <div><a href="{{ asset($settings['news_base']) }}">@lang('general.more_news') »</a></div>
                </div>

                <div class="row news">

                    @foreach ($latest_news as $key => $news)

                    <div class="col-md-6 col-12 mb-3 @if ($key++ % 2 != 1) pr-md-2 @else pl-md-2 @endif">
                        <div class="news-box">
                            <a href="{{ asset($settings['news_base']) }}/{{ $news->slug }}">
                                <div class="news-cover"></div>
                                <h4>{{ $news->title}}</h4>
                                <img src="{{ asset('images') }}/news/{{ $news->image}}" class="img-fluid" alt="{{ $news->title}}">
                            </a>
                        </div>
                    </div>

                    @endforeach

                </div>
                <!-- /Tech news -->
                @endif

                @if (!is_null($ad[11]))<div class="mb-3">{!! $ad[11] !!}</div>@endif

                @if (count($featured_apps) > 0)
                <!-- Featured apps -->
                <div class="d-flex top-title justify-content-between">
                    <div>@lang('general.featured_apps')</div>
                    <div><a href="{{ asset('featured-apps') }}">@lang('general.more') »</a></div>
                </div>

                <div class="featured-apps page-left mr-3 ml-3">
                    <div class="row flex-nowrap mb-1 pb-2">
                        @foreach ($featured_apps as $app_category)

                        @if(empty($app_category->image))
                        @php $app_category->image='no_image.png'; @endphp
                        @endif

                        <div class="col-half p-2 @if($loop->last) mr-0 @endif"><a
                                href="{{ asset($settings['app_base']) }}/{{ $app_category->slug }}">
                            <img src="{{ asset('images') }}/{{$app_category->image}}" class="img-fluid rounded" alt="{{$app_category->title}}">
                            <span>{{$app_category->title}}</span></a></div>
                        @endforeach
                    </div>
                </div>
                <!-- /Featured apps -->
                @endif

                @if (!is_null($ad[12]))<div class="mt-3">{!! $ad[12] !!}</div>@endif

                @if (count($must_have_apps) > 0)
                <!-- Must-Have Apps -->
                <div class="d-flex top-title justify-content-between mb-3 mt-3">
                    <div>@lang('general.must_have_apps')</div>
                    <div><a href="{{ asset('must-have-apps') }}">@lang('general.more') »</a></div>
                </div>

                <div class="row apps">
                    @foreach ($must_have_apps as $app)

                    @if(empty($app->image))
                    @php $app->image='no_image.png'; @endphp
                    @endif

                    <div class="col-4 mb-2">
                        
                        <div class="d-flex flex-sm-row flex-column app-box" style="position: relative;overflow: hidden;">
                            <div style="position:absolute; right: -150px;top: 0px;transition: .3s all ease-in-out;" class="download-btn">
                                <a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}" class="btn btn-primary btn-sm" style="font-size:14px;padding: 10px  23px;">Download</a>
                            </div>
                            
                            <div class="pr-2 mb-1"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}">
                                <img src="{{ asset('images') }}/{{ $app->image }}" class="image rounded" alt="{{ $app->title }}"></a></div>
                            <div class="box"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}"
                                    class="title">{{ $app->title }}</a>

                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++) @if($i<=round($app->votes))
                                        <span class="fa fa-star checked"></span>
                                        @else
                                        <span class="fa fa-star"></span>
                                        @endif
                                        @endfor
                                </div>

                                <span class="category">{{ $category_name[$app->category] }}</span>
                                <span class="license">{{ $app->license }}</span>

                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <!-- /Must-Have Apps -->
                @endif

                @if (!is_null($ad[13]))<div class="mb-3 mt-1">{!! $ad[13] !!}</div>@endif

                @if (count($all_topics) > 0)
                <!-- Topics -->
                <div class="d-flex top-title justify-content-between mt-2">
                    <div>@lang('general.topics')</div>
                    <div><a href="{{ asset($settings['topic_base']) }}">@lang('general.more_topics') »</a></div>
                </div>

                <div class="topics-home mr-3 ml-3">

                    <div class="row flex-nowrap topics">

                        @foreach ($all_topics as $key => $topics)

                        <div class="col-topic p-3 @if($loop->last) mr-0 @endif">

                            <a href="{{ asset($settings['topic_base']) }}/{{ $topics->slug }}">
                                <img src="{{ asset('images') }}/topics/{{ $topics->image}}" class="img-fluid" alt="{{ $topics->title}}">
                            </a>
                            <div class="topic-box">
                                <a href="{{ asset($settings['topic_base']) }}/{{ $topics->slug }}">
                                    {{ $topics->title}}
                                </a>
                            </div>
                        </div>

                        @endforeach

                    </div>
                </div>
                <!-- /Tppics -->
                @endif

                @if (!is_null($ad[15]))<div class="mb-3 mt-1">{!! $ad[15] !!}</div>@endif     

                @if (count($apps_24_hours) > 0)
                <!-- Popular apps in last 24 hours -->
                <div class="d-flex top-title justify-content-between mt-1 mb-3">
                    <div>@lang('general.popular_apps_24_hours')</div>
                    <div><a href="{{ asset('popular-apps-in-last-24-hours') }}">@lang('general.more') »</a></div>
                </div>

                <div class="row apps mb-1">
                    @php $x=1; @endphp
                    @foreach ($apps_24_hours as $app)

                    @if(empty($app->image))
                    @php $app->image='no_image.png'; @endphp
                    @endif

                    @if($x<=9) <div class="col-4 mb-2">
                        
                        <div class="d-flex flex-sm-row flex-column app-box" style="position: relative;overflow: hidden;">
                            <div style="position:absolute; right: -150px;top: 0px;transition: .3s all ease-in-out;" class="download-btn">
                                <a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}" class="btn btn-primary btn-sm" style="font-size:14px;padding: 10px  23px;">Download</a>
                            </div>
                            
                            <div class="pr-2 mb-1">
                            <a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}"><img
                                        src="{{ asset('images') }}/{{ $app->image }}" class="image rounded" alt="{{ $app->title }}"></a></div>
                            <div class="box"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}"
                                    class="title">{{ $app->title }}</a>

                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++) @if($i<=round($app->votes))
                                        <span class="fa fa-star checked"></span>
                                        @else
                                        <span class="fa fa-star"></span>
                                        @endif
                                        @endfor
                                </div>

                                <span class="category">{{ $category_name[$app->category] }}</span>
                                <span class="license">{{ $app->license }}</span>

                            </div>
                        </div>
                </div>
                @endif
                @php $x++; @endphp
                @endforeach

            </div>
            <!-- /Popular apps in last 24 hours -->
            @endif

            @if (!is_null($ad[6])){!! $ad[6] !!}@endif


        </div>
        <!-- /Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 bl-1 mb-3">
            @if (!is_null($ad[3]))<div class="mb-3">{!! $ad[3] !!}</div>@endif
            @include('frontend::inc.top', ['type' => '1'])
            @if (!is_null($ad[4]))<div class="mt-3">{!! $ad[4] !!}</div>@endif
            @include('frontend::inc.top', ['type' => '4'])
            @if (!is_null($ad[14]))<div class="mt-3">{!! $ad[14] !!}</div>@endif
        </div>
        <!-- /Grid column -->

    </div>
    <!-- /Grid row -->

</div>
<!-- /Container -->

</div>
<!-- /Big Container -->

@endsection