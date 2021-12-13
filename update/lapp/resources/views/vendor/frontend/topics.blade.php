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
                    <a href="{{ asset('') }}">@lang('general.homepage')</a> » <a href="{{url()->current()}}">@lang('general.topics')</a>
                </div>

                @if ($settings['schema_breadcrumbs'] == '1')
                {!! $breadcrumb_schema_data->toScript() !!}
                @endif

                @endif

                <div class="row topics no-gutters">

                    @foreach ($all_topics as $key => $topics)

                    <div class="col-md-6 col-12 mb-3 @if ($key++ % 2 != 1) pr-md-2 @else pl-md-2 @endif">

                        <a href="{{ asset($settings['topic_base']) }}/{{ $topics->slug }}">
                            <img src="{{ asset('images') }}/topics/{{ $topics->image}}" class="img-fluid" alt="">
                        </a>
                        <div class="topic-box">
                            <a href="{{ asset($settings['topic_base']) }}/{{ $topics->slug }}">
                                {{ $topics->title}}
                            </a>
                        </div>
                    </div>

                    @endforeach

                </div>

                <div class="d-flex">
                    <div class="mx-auto">
                        {{ $all_topics->onEachSide(1)->links() }}
                    </div>
                </div>

                @if (!is_null($ad[6])){!! $ad[6] !!}@endif

            </div>
            <!-- /Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 bl-1 mb-3">
                @if (!is_null($ad[3]))<div class="mb-3">{!! $ad[3] !!}</div>@endif
                @if(!$popular_apps->isEmpty())@include('frontend::inc.top', ['type' => '2'])@endif
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