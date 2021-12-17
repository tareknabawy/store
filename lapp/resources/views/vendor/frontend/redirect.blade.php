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

                    @if (!is_null($ad[8]))<div class="mb-3">{!! $ad[8] !!}</div>@endif

                    <span class="redirecting">@if($app_query->type=='1')
                            @lang('general.downloading_message')@else
                            @lang('general.redirecting_message')@endif<span>.</span><span>.</span><span>.</span>
                </span>

                @if(empty($app_query->image))
                @php $app_query->image='no_image.png'; @endphp
                @endif

                    <div class="d-flex flex-row redirect" id="redirect" data-app-id="{{ $app_query->id }}" data-redirection-delay="{{$settings['time_before_redirect']*1000}}">

                        <div class="mr-3">
                            <img src="{{ asset('images') }}//{{$app_query->image}}" alt="{{$app_query->title}}" class="float-left pimage"></div>

                        <div><h2>{{$app_query->title}}</h2>
                            <span class="voteinfo"></span>
                            <div>@lang('general.rating'): <strong>{{$app_query->votes}}</strong> (@lang('general.votes')
                                : {{$app_query->total_votes}})
                            </div>
                            <div class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i<=round($app_query->votes))
                                        <span class="fa fa-star checked"></span>
                                    @else
                                        <span class="fa fa-star"></span>
                                    @endif
                                @endfor
                            </div>
                        </div>

                    </div>

                    @if (!is_null($ad[7]))
                        <div class="mt-3">{!! $ad[7] !!}</div>@endif

                </div>
                <!-- /Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 bl-1 mb-3">
                    @if (!is_null($ad[3]))
                        <div class="mb-3">{!! $ad[3] !!}</div>@endif
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
