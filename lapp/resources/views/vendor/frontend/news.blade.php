@extends('frontend::page')
@section('content')
<!-- Big Container -->
<div class="big-container mt-3">
<!-- Container -->
<div class="container">
<!-- Grid row -->
<div class="row">
<!-- Grid column -->
            <div class="col-md-8 page-content news-page mb-3">
                @if (!is_null($ad[5]))<div class="mb-3">{!! $ad[5] !!}</div>@endif
                @if ($settings['breadcrumbs'] == '1')
                <div class="breadcrumbs mb-3">
            <a href="{{ asset('') }}">@lang('general.homepage')</a> » <a href="{{ asset($settings['news_base']) }}">@lang('general.tech_news')</a> » <a href="{{url()->current()}}">{{$page_query->title}}</a>
                </div>
                
                @if ($settings['schema_breadcrumbs'] == '1')
                {!! str_replace('\\', '', $breadcrumb_schema_data->toScript()) !!}
                @endif
                @endif
                
                @if ($settings['reading_time'] == '1')
                <span class="news-reading-time">{!! $reading_time !!} read</span>
                @endif
                <h2 class="news-title">{{$page_query->title}}</h2>
                <h3 class="news-description">{!! $page_query->description !!}</h3>
                
                
                <span class="news-date">{{$page_query->updated_at}}-{{\Carbon\Carbon::parse($page_query->created_at)->translatedFormat('F d, Y H:i')}}</span>
                  <div class="container smi">
                    <div class="row">
                        <div class="col text-center p-2 facebook"><a onclick="sm_share('https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}','Facebook','600','300');" href="javascript:void(0);"><i class="fab fa-facebook-f ml-2"></i> <span class="d-none d-lg-inline-block">Facebook</span></a></div>
                        <div class="col text-center p-2 twitter"><a onclick="sm_share('http://twitter.com/share?text={{$page_query->title}}&url={{url()->current()}}','Twitter','600','300');" href="javascript:void(0);"><i class="fab fa-twitter ml-2"></i> <span class="d-none d-lg-inline-block">Twitter</span></a></div>
                        <div class="col text-center p-2 linkedin"><a onclick="sm_share('https://www.linkedin.com/sharing/share-offsite/?url={{url()->current()}}','Linkedin','600','300');" href="javascript:void(0);"><i class="fab fa-linkedin-in ml-2"></i> <span class="d-none d-lg-inline-block">Linkedin</span></a></div>
                        <div class="col text-center p-2 email"><a href="mailto:?subject={{$page_query->title}}&amp;body={{url()->current()}}"><i class="fas fa-envelope ml-2"></i> <span class="d-none d-lg-inline-block">E-mail</span></a></div>
                        <div class="col text-center p-2 whatsapp"><a onclick="sm_share('https://api.whatsapp.com/send?text={{$page_query->title}} {{url()->current()}}','WhatsApp','700','650');" href="javascript:void(0);"><i class="fab fa-whatsapp ml-2"></i> <span class="d-none d-lg-inline-block">WhatsApp</span></a></div>
                    </div>
                </div>
                  <img src="{{ asset('images') }}/news/{{ $page_query->image}}" class="img-fluid mt-md-3" alt="{{ $page_query->image}}" >

                {!! $page_query->details !!} 
                <div class="col-12 p-3 " style="padding: 20px">
                    @if (isset($page_query->tags))
                        @if (count($page_query->tags) > 0)
                        <div class="tags pt-3">
                            <span>@lang('general.tags')</span>
                            <ul>
                        @foreach ($page_query->tags as $tag)
                                <li><a href="{{ asset($settings['tag_base']) }}/{{ $tag['slug'] }}">{{ $tag['name'] }}</a></li>

                                @endforeach

                            </ul>
                        </div>
                        @endif
                    @endif
                @if (count($other_news) > 0)

                <div class="other-news-title mt-4 mb-4">
                    <span>@lang('general.other_news')</span>
                </div>

                <div class="row other-news mt-3">

                    @foreach ($other_news as $key => $news)
                    <div class="col-md-6 col-12 mb-3 @if ($key++ % 2 != 1) pr-md-2 @else pl-md-2 @endif">
                        <a href="{{ asset($settings['news_base']) }}/{{ $news->slug }}"><img src="{{ asset('images') }}/news/{{$news->image}}" loading="lazy" class="img-fluid" alt="{{ $news->slug }}"></a>
                        <a href="{{ asset($settings['news_base']) }}/{{ $news->slug }}"><span>{{$news->title}}</span></a>
                    </div>
                    @endforeach
                   </div>
                    @endif
                    @if (!is_null($ad[6]))
                    {!! $ad[6] !!}@endif
                  </div>
            <!-- /Grid column -->
            <!-- Grid column -->
            <div class="col-md-4 bl-1 mb-3">
                @if (!is_null($ad[3]))<div class="mb-3">{!! $ad[3] !!}</div>@endif
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