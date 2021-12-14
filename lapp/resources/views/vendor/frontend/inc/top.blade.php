@foreach ($categories as $category)
@php $category_name[$category->id]=$category->title; @endphp
@endforeach

@if($type =='1' OR $type =='2' OR $type =='3')
@if (count($popular_apps) > 0)

<div class="top-title">
    @if($type =='1')
    @lang('general.popular_downloads')
    @endif
    @if($type =='2')
    @lang('general.popular_downloads_category')
    @endif
    @if($type =='3')
    @lang('general.popular_downloads_platform')
    @endif <i class="fas fa-angle-down float-right"></i></div>

<div class="row apps top mt-2">
    @php $i = 1; @endphp

    @foreach ($popular_apps as $app)

    @if(empty($app->image))
    @php $app->image='no_image.png'; @endphp
    @endif

    <div class="col-md-12 col-12">
        <div class="d-flex @if($loop->last) mb-0 pb-0 border-0 @endif">
            <div class="my-auto">
                <div
                    class="rank @if($i <= '3')green @else pink @endif">
                    {{ $loop->iteration }}</div>
            </div>
            <div class="mr-2"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}"><img
                        src="{{ asset('images') }}/{{ $app->image }}" class="image rounded"></a></div>
            <div class="box"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}" class="title">{{ $app->title }}</a>

                <div class="stars">
                    @for ($x = 1; $x <= 5; $x++) @if($x<=round($app->votes))
                        <span class="fa fa-star checked"></span>
                        @else
                        <span class="fa fa-star"></span>
                        @endif
                        @endfor
                </div>

                <span class="category">{{ $category_name[$app->category] }}</span>

            </div>
        </div>
    </div>
    @php $i++; @endphp

    @endforeach
</div>
@endif
@endif

@if($type =='4')

@if (count($editors_choice) > 0)
<div class="top-title mt-3">@lang('general.editors_choice')<i class="fas fa-medal float-right"></i></div>

<div class="row apps top mt-2">
    @php $i = 1; @endphp

    @foreach ($editors_choice as $app)

    @if(empty($app->image))
    @php $app->image='no_image.png'; @endphp
    @endif

    <div class="col-md-12 col-12 app-box" style="position: relative;overflow: hidden;">
        <div class="d-flex @if($loop->last) mb-0 pb-0 border-0 @endif">

       
                            <div style="position:absolute; right: -150px;top: 0px;transition: .3s all ease-in-out;" class="download-btn">
                                <a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}" class="btn btn-primary btn-sm" style="font-size:14px;padding: 10px  23px;">Download</a>
                            </div>

            <div class="pr-2"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}"><img
                        src="{{ asset('images') }}/{{ $app->image }}" class="image rounded"></a></div>
            <div class="box"><a href="{{ asset($settings['app_base']) }}/{{ $app->slug }}" class="title">{{ $app->title }}</a>

                <div class="stars">
                    @for ($i = 1; $i <= 5; $i++) @if($i<=round($app->votes))
                        <span class="fa fa-star editor-star checked"></span>
                        @else
                        <span class="fa fa-star"></span>
                        @endif
                        @endfor
                </div>

                <span class="category">{{ $category_name[$app->category] }}</span>

            </div>
        </div>
    </div>
    @php $i++; @endphp

    @endforeach
</div>
@endif
@endif