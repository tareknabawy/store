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

                @foreach ($platforms as $platform)
                @php $platform_name[$platform->id]=$platform->title; @endphp
                @endforeach

                @if ($settings['breadcrumbs'] == '1')
                <div class="breadcrumbs mb-3">
                    <a href="{{ asset('') }}">@lang('general.homepage')</a> » <a href="{{url()->current()}}">{{ $platform_name[$platform_query->id] }}</a>
                </div>

                @if ($settings['schema_breadcrumbs'] == '1')
                {!! $breadcrumb_schema_data->toScript() !!}
                @endif

                @endif

                @if($apps->isEmpty())
                <h6 class="alert alert-warning">@lang('general.no_record_platform').</h6>
                @endif

                <div class="row apps mb-1">
                    @foreach ($apps as $app)

                    @if(empty($app->image))
                    @php $app->image='no_image.png'; @endphp
                    @endif

                    <div class="col-4 mb-2">
                        <div class="d-flex flex-sm-row flex-column">
                            <div class="pr-2 mb-1"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}"><img src="{{ asset('images') }}/{{ $app->image }}" class="image rounded" alt="{{ $app->slug }}"></a></div>
                            <div class="box"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}" class="title">{{ $app->title }}</a>

                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++) @if($i<=round($app->votes))
                                        <span class="fa fa-star checked"></span>
                                        @else
                                        <span class="fa fa-star"></span>
                                        @endif
                                        @endfor
                                </div>

                                <span class="date">{{\Carbon\Carbon::parse($app->created_at)->translatedFormat('M d, Y')}}</span>
                                <span class="license text-success">{{ $app->license }}</span>

                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                <div class="d-flex">
                    <div class="mx-auto">
                        {{ $apps->onEachSide(1)->links() }}
                    </div>
                </div>

                @if (!is_null($ad[6]))<div class="mt-3">{!! $ad[6] !!}</div>@endif

            </div>
            <!-- /Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 bl-1 mb-3">
                @if (!is_null($ad[3]))<div class="mb-3">{!! $ad[3] !!}</div>@endif
                @if(!$popular_apps->isEmpty())@include('frontend::inc.top', ['type' => '3'])@endif
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