@extends('frontend::page')

@push('assets_header')
<!-- Lity CSS -->
<link href="{{ asset('css/simpleLightbox.min.css') }}" rel="stylesheet">
@endpush

@push('assets_footer')
<!-- Popper -->
<script src="{{ asset('js/popper.min.js') }}"></script>

<!-- Lity JS -->
<script src="{{ asset('js/simpleLightbox.min.js') }}"></script>

<!-- Rating JS -->
<script src="{{ asset('js/rating.js') }}"></script>
@endpush

@section('content')

<!-- Big Container -->
<div class="big-container mt-3">

    <!-- Container -->
    <div class="container">

        <!-- Grid row -->
        <div class="row">

            <!-- Grid column -->
            <div class="col-md-8 page-content mb-3">

                @if (!is_null($ad[5]))
                <div class="mb-3">{!! $ad[5] !!}</div>@endif

                @if ($settings['breadcrumbs'] == '1')
                <div class="breadcrumbs mb-3">
                    <a href="{{ asset('') }}">@lang('general.homepage')</a> » <a href="{{ asset($settings['platform_base']) }}/{{ $data_to_pass['platform_slug'] }}">{{ $data_to_pass['platform_name'] }}</a> » <a href="{{ asset($settings['category_base']) }}/{{ $data_to_pass['category_slug'] }}">{{ $data_to_pass['category_name'] }}</a> » <a href="{{url()->current()}}">{{$app_query->title}}</a>
                </div>

                @if ($settings['schema_breadcrumbs'] == '1')
                {!! $breadcrumb_schema_data->toScript() !!}
                @endif

                @endif

                <div class="d-flex flex-row app-info">

                    <div class="mr-2"><img src="{{ asset('images') }}/{{$app_query->image}}" class="float-left pimage">
                    </div>

                    <div>
                        <h2>{{$app_query->title}}</h2>

                        <span class="voteinfo"></span>
                        <div>@lang('general.rating'): <strong>{{$app_query->votes}}</strong> (@lang('general.votes'):
                            {{$app_query->total_votes}})
                        </div>

                        <div class="ratings" id="rating" data-rating-id="{{$app_query->id}}">
                            @for ($i = 1; $i <= 5; $i++) @if($i<=round($app_query->votes))
                                <input type="radio" name="vote" class="rating" value="{{$i}}" checked="checked" />
                                @else
                                <input type="radio" name="vote" class="rating" value="{{$i}}" />
                                @endif
                                @endfor
                        </div>

                    </div>
                </div>

                <div class="container mt-3 smi">
                    <div class="row">
                        <div class="col text-center p-2 facebook"><a onclick="sm_share('https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}','Facebook','600','300');" href="javascript:void(0);"><i class="fab fa-facebook-f ml-2"></i> <span class="d-none d-lg-inline-block">Facebook</span></a></div>
                        <div class="col text-center p-2 twitter"><a onclick="sm_share('http://twitter.com/share?text={{$app_query->title}}&url={{url()->current()}}','Twitter','600','300');" href="javascript:void(0);"><i class="fab fa-twitter ml-2"></i> <span class="d-none d-lg-inline-block">Twitter</span></a></div>
                        <div class="col text-center p-2 linkedin"><a onclick="sm_share('https://www.linkedin.com/sharing/share-offsite/?url={{url()->current()}}','Linkedin','600','300');" href="javascript:void(0);"><i class="fab fa-linkedin-in ml-2"></i> <span class="d-none d-lg-inline-block">Linkedin</span></a></div>
                        <div class="col text-center p-2 email"><a href="mailto:?subject={{$app_query->title}}&amp;body={{url()->current()}}"><i class="fas fa-envelope ml-2"></i> <span class="d-none d-lg-inline-block">E-mail</span></a></div>
                        <div class="col text-center p-2 whatsapp"><a onclick="sm_share('https://api.whatsapp.com/send?text={{$app_query->title}} {{url()->current()}}','WhatsApp','700','650');" href="javascript:void(0);"><i class="fab fa-whatsapp ml-2"></i> <span class="d-none d-lg-inline-block">WhatsApp</span></a></div>
                    </div>
                </div>


                @if ($app_query->screenshots != "")
                <div class="container screenshots mt-3">
                    <div class="row">

                        <div id="left"><i class="fas fa-angle-left"></i></div>
                        <div id="right"><i class="fas fa-angle-right"></i></div>

                        <div id="screenshot-main">

                            @foreach($screenshot_data as $image_name)
                            <a href="{{ asset('screenshots') }}/{{$image_name}}"><img src="{{ asset('screenshots') }}/{{$image_name}}" class="mr-1"></a>
                            @endforeach

                        </div>
                    </div>
                </div>
                @endif

                <div class="description" id="description" data-show-more="@lang('general.show_more')" data-show-less="@lang('general.show_less')">

                    <p>{{{ $app_query->description }}}</p>
                    {!! $app_query->details !!}

                </div>

                @if (isset($app_query->tags))
                @if (count($app_query->tags) > 0)

                <div class="tags pt-3">
                    <span>@lang('general.tags')</span>
                    <ul>

                        @foreach ($app_query->tags as $tag)
                        <li><a href="{{ asset($settings['tag_base']) }}/{{ $tag['slug'] }}">{{ $tag['name'] }}</a></li>
                        @endforeach

                    </ul>
                </div>

                @endif
                @endif

                <div class="review-title mt-3 pt-3">@lang('general.user_reviews')<a href="#" class="add-comment btn btn-success float-right">@lang('general.add_comment_review')</a>
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++) @if($i<=round($app_query->votes))
                            <span class="fa fa-star checked"></span>
                            @else
                            <span class="fa fa-star"></span>
                            @endif
                            @endfor
                    </div>
                </div>

                <div class="user-votes-total mt-2">@lang('general.based_on') {{$app_query->total_votes}}
                    @lang('general.votes') @lang('general.and')
                    {{ $data_to_pass['total_comments'] }} @lang('general.user_reviews')</div>

                <div class="user-ratings container mt-3">

                    @foreach ($comment_order as $rating => $total_rating )

                    @php $bar_length=@(100/$data_to_pass[total_comments])*$total_rating; @endphp

                    <div class="row">
                        <div class="col-2 p-0 rating">{{ trans_choice('general.star', $rating) }}</div>
                        <div class="col-9">
                            <div class="progress" data-bar-width="{{$bar_length}}">
                                <div class="progress-bar"></div>
                            </div>
                        </div>
                        <div class="col-1 p-0 votes text-center">{{$total_rating}}</div>
                    </div>

                    @endforeach

                </div>

                <div class="user-reviews">

                    @if ($app_comments->isEmpty())
                    <div class="alert alert-info show mt-1" role="alert">@lang('general.no_reviews_yet')</div>
                    @endif

                    @foreach ($app_comments as $comment)

                    <div class="review mt-2">
                        <p class="title">"{{{$comment->title}}}"</p>
                        <div class="row">
                            <div class="col-6">
                                <p class="name">{{{$comment->name}}}</p>
                            </div>
                            <div class="col-6">
                                <div class="stars float-right">
                                    @for ($i = 1; $i <= 5; $i++) @if($i<=round($comment->rating))
                                        <span class="fa fa-star checked"></span>
                                        @else
                                        <span class="fa fa-star"></span>
                                        @endif
                                        @endfor
                                </div>
                            </div>
                        </div>
                        <p class="date" data-toggle="tooltip" title="{{\Carbon\Carbon::parse($comment->created_at)->translatedFormat('F d, Y H:i:s')}}">
                            {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</p>

                        <p class="comment">{{{$comment->comment}}}</p>
                    </div>

                    @endforeach

                    @if (count($app_comments) > '3')
                    <div class="rm-link show-more">@lang('general.show_more')</div>
                    @endif

                    <div class="comment-box" id="comment-section" data-fill-all-fields="@lang('general.fill_all_fields')">

                        <form id="comment-form">

                            <div class="review-title mt-3 mb-2 pt-3" id="review-title">
                                @lang('general.add_comment_review')</div>

                            <input type="hidden" name="app_id" value="{{$app_query->id}}" />

                            <div class="form-group">
                                <label for="name">@lang('general.your_name'): <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="title">@lang('general.comment_title'): <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="form-group">
                                <label for="email">@lang('general.your_email'): <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <small id="emailHelp" class="form-text text-muted">@lang('general.email_notification')</small>
                            </div>

                            <div class="form-group">
                                <label for="comment">@lang('general.your_comment'): <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="5" id="comment" name="comment" maxlength="1000" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="rating">@lang('general.your_rating'): <span class="text-danger">*</span></label>
                                <div class="form-check-inlin user_ratings">
                                    <input type="radio" id="user_rating" name="user_rating" value="1">
                                    <input type="radio" id="user_rating" name="user_rating" value="2">
                                    <input type="radio" id="user_rating" name="user_rating" value="3">
                                    <input type="radio" id="user_rating" name="user_rating" value="4">
                                    <input type="radio" id="user_rating" name="user_rating" value="5" checked>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </form>

                        <button type="submit" class="btn m-0 comment-button" onclick="form_control()">@lang('general.submit')</button>

                        <div id="comment_result">
                            <div class="alert alert-warning show mt-3" role="alert">
                                @lang('general.comment_rules')</div>
                        </div>

                    </div>
                </div>

                @if (count($latest_news) > 0)
                <!-- Tech News -->
                <div class="d-flex top-title justify-content-between mb-3 mt-3">
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
                                <img src="{{ asset('images') }}/news/{{ $news->image}}" class="img-fluid" alt="">
                            </a>
                        </div>
                    </div>

                    @endforeach

                </div>
                <!-- /Tech news -->
                @endif

                <!-- Other Apps in This Category -->
                <div class="d-flex top-title justify-content-between">
                    <div>@lang('general.other_apps_in_category')</div>
                    <div>
                        <a href="{{ asset('category') }}/{{ $data_to_pass['category_slug'] }}">@lang('general.more')
                            »</a></div>
                </div>

                <div class="featured-apps mr-3 ml-3">
                    <div class="row flex-nowrap page-left mb-1 pb-2">
                        @foreach ($apps_category as $app_category)

                        @if(empty($app_category->image))
                        @php $app_category->image='no_image.png'; @endphp
                        @endif

                        <div class="col-half p-2 @if($loop->last) mr-0 @endif"><a href="{{ asset($settings['app_base']) }}/{{ $app_category->slug }}"><img src="{{ asset('images') }}/{{$app_category->image}}" class="img-fluid rounded"><span>{{$app_category->title}}</span></a>
                        </div>
                        @endforeach
                    </div>

                </div>
                <!-- /Other Apps in This Category -->

                @if (!is_null($ad[6]))<div class="mt-3">{!! $ad[6] !!}</div>@endif

            </div>
            <!-- /Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 bl-1 mb-3">

                <div id="move_item"></div>

                <div id="download_section">
                    <div class="download">

                        @if($app_query->type=='1')
                        <a href="{{ url('/redirect/' . $app_query->slug) }}" class="btn m-0"><i class="fas fa-download"></i>
                            @lang('general.download_now')</a>
                        @else
                        <a href="{{ url('/redirect/' . $app_query->slug) }}" class="btn m-0"><i class="fas fa-external-link-alt"></i> @lang('general.visit_page')</a>
                        @endif

                        @if(!empty($app_query->buy_url))
                        <a href="{{ $app_query->buy_url }}" target="_blank" class="btn buy-btn mt-3"><i class="fas fa-tag"></i>
                            @lang('general.buy_now')</a>
                        @endif

                    </div>

                    <div class="show-qr-code mt-2"><i class="fas fa-qrcode"></i>
                        @if($app_query->type=='1')
                        @lang('general.qr_download')
                        @else
                        @lang('general.qr_visit')
                        @endif
                        <div class="qr-code">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->margin(0)->size(125)->generate(url()->current())); !!} ">
                        </div>
                    </div>

                    <ul class="specs">
                        <li><strong>@lang('general.category'):</strong> {{ $data_to_pass['category_name'] }}</li>
                        <li><strong>@lang('general.platform'):</strong> {{ $data_to_pass['platform_name'] }}</li>
                        <li><strong>@lang('general.developer'):</strong> {{$app_query->developer}}</li>
                        @if(!empty($app_query->file_size))
                        <li><strong>@lang('general.file_size'):</strong> {{$app_query->file_size}}</li>@endif
                        @if($app_query->type=='1')
                        <li><strong>@lang('general.downloads'):</strong> {{$app_query->counter}}</li>
                        @else
                        <li><strong>@lang('general.visits'):</strong> {{$app_query->counter}}</li>@endif
                        @if(!empty($app_query->license))
                        <li><strong>@lang('general.license'):</strong> {{$app_query->license}}</li>@endif
                        <li><strong>@lang('general.last_update'):</strong>
                            {{\Carbon\Carbon::parse($app_query->updated_at)->translatedFormat('F d, Y')}}</li>
                    </ul>

                </div>

                <!-- Trending apps -->
                <div class="d-flex top-title justify-content-between mt-md-3" id="popular_apps">
                    <div>@lang('general.popular_downloads_category')</div>
                    <div><i class="fas fa-angle-down"></i></div>
                </div>

                <div class="featured-apps app-page mr-3 ml-3">
                    <div class="row flex-nowrap mb-1 pb-2">
                        @foreach ($popular_apps as $app_category)

                        @if(empty($app_category->image))
                        @php $app_category->image='no_image.png'; @endphp
                        @endif

                        <div class="col-half p-2 @if($loop->last) mr-0 @endif"><a href="{{ asset($settings['app_base']) }}/{{ $app_category->slug }}"><img src="{{ asset('images') }}/{{$app_category->image}}" class="img-fluid rounded"><span>{{$app_category->title}}</span></a>
                        </div>
                        @endforeach
                    </div>

                </div>
                <!-- /Trending apps -->

                @if (!is_null($ad[4]))
                <div class="mt-3">{!! $ad[4] !!}</div>@endif
                @include('frontend::inc.top', ['type' => '4'])
                @if (!is_null($ad[14]))
                <div class="mt-3">{!! $ad[14] !!}</div>@endif

            </div>
            <!-- /Grid column -->

        </div>
        <!-- /Grid row -->

    </div>
    <!-- /Container -->

</div>
<!-- /Big Container -->

@endsection