@extends('frontend::page')

@section('content')

<!-- Big Container -->
<div class="big-container mt-3">

    <!-- Container -->
    <div class="container">

        <!-- Grid row -->
        <div class="row">

            <!-- Grid column -->
            <div class="col-md-8 page-content mb-3">

                @foreach ($apps as $app)
                @php $app_title[$app->id]=$app->title; @endphp
                @php $app_image[$app->id]=$app->image; @endphp
                @php $app_slug[$app->id]=$app->slug; @endphp
                @php $app_description[$app->id]=$app->description; @endphp
                @php $app_votes[$app->id]=$app->votes; @endphp
                @php $app_license[$app->id]=$app->license; @endphp
                @endforeach

                @if (!is_null($ad[5]))<div class="mb-3">{!! $ad[5] !!}</div>@endif

                @if ($settings['breadcrumbs'] == '1')
                <div class="breadcrumbs mb-3">
                    <a href="{{ asset('') }}">@lang('general.homepage')</a> » <a href="{{ asset($settings['topic_base']) }}">@lang('general.topics')</a> » <a href="{{url()->current()}}">{{$topic_query->title}}</a>
                </div>

                @if ($settings['schema_breadcrumbs'] == '1')
                {!! $breadcrumb_schema_data->toScript() !!}
                @endif

                @endif

                <h2 class="mb-0 mb-md-3">{!! $topic_query->title !!}</h2>

                <div class="container smi">
                    <div class="row">
                        <div class="col text-center p-2 facebook"><a onclick="sm_share('https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}','Facebook','600','300');" href="javascript:void(0);"><i class="fab fa-facebook-f ml-2"></i> <span class="d-none d-lg-inline-block">Facebook</span></a></div>
                        <div class="col text-center p-2 twitter"><a onclick="sm_share('http://twitter.com/share?text={{$topic_query->title}}&url={{url()->current()}}','Twitter','600','300');" href="javascript:void(0);"><i class="fab fa-twitter ml-2"></i> <span class="d-none d-lg-inline-block">Twitter</span></a></div>
                        <div class="col text-center p-2 linkedin"><a onclick="sm_share('https://www.linkedin.com/sharing/share-offsite/?url={{url()->current()}}','Linkedin','600','300');" href="javascript:void(0);"><i class="fab fa-linkedin-in ml-2"></i> <span class="d-none d-lg-inline-block">Linkedin</span></a></div>
                        <div class="col text-center p-2 email"><a href="mailto:?subject={{$topic_query->title}}&amp;body={{url()->current()}}"><i class="fas fa-envelope ml-2"></i> <span class="d-none d-lg-inline-block">E-mail</span></a></div>
                        <div class="col text-center p-2 whatsapp"><a onclick="sm_share('https://api.whatsapp.com/send?text={{$topic_query->title}} {{url()->current()}}','WhatsApp','700','650');" href="javascript:void(0);"><i class="fab fa-whatsapp ml-2"></i> <span class="d-none d-lg-inline-block">WhatsApp</span></a></div>
                    </div>
                </div>

                <img src="{{ asset('images') }}/topics/{{ $topic_query->image}}" class="img-fluid mt-3" alt="{!! $topic_query->title !!}">

                <h3 class="topic-description">{!! $topic_query->description !!}</h3>

                @if (count($topic_list_query) > 0)

                <!-- Topics List -->

                <div class="row topicitems mt-3">
                    @foreach ($topic_list_query as $index => $app)
                    @if (!empty($app_title[$app]))

                    @if(empty($app_image[$app]))
                    @php $app_image[$app]='no_image.png'; @endphp
                    @endif

                    <div class="col-12 mb-2">
                        <div class="d-flex">
                            <div class="pr-2 text-center">

                                @if(!empty($app_license[$app]))
                                <span class="license">{{ $app_license[$app] }}</span>
                                @endif

                                <a href="{{ asset($settings['app_base']) }}/{{ $app_slug[$app] }}"><img src="{{ asset('images') }}/{{ $app_image[$app] }}" alt="+++++++++++++" class="rounded"></a>

                                <div class="apps mb-2">
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++) @if($i<=round($app_votes[$app])) <span class="fa fa-star editor-star checked"></span>
                                            @else
                                            <span class="fa fa-star"></span>
                                            @endif
                                            @endfor
                                    </div>
                                </div>
                            </div>

                            <div class="box">
                                <a href="{{ asset($settings['app_base']) }}/{{ $app_slug[$app] }}" class="title">{{ $index+1 }}. {{ $app_title[$app] }}</a>

                                <span class="description">{{ $app_description[$app] }}</span>

                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach

                </div>

                <!-- /Topics List -->

                @endif

                @if (!is_null($ad[6])){!! $ad[6] !!}@endif

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