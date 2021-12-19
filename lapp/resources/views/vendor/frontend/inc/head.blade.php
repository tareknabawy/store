<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="profile" href="https://gmpg.org/xfn/11">
<meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />

{!!
\MetaTag::setPath()
->setDefault(['robots' => 'follow', 'canonical' => url()->current()])
->setDefault(['og_site_name' => $settings['site_title']])
->setDefault(['og_locale' => $locale_tags[$settings['site_language']]])
->render()
!!}
@if (\Request::is("$settings[app_base]/*"))
{!! $schema_data->toScript() !!}
@endif

<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="alternate" type="application/rss+xml" title="{{$settings['site_title']}}" href="{{ asset('rss') }}" />
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />

<!-- Bootstrap 4.3.1 -->
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<!-- Common Styles -->
<link href="{{ asset('css/app.css') }}?v1.4" rel="stylesheet">
<!-- jQuery -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<!-- Other JS -->
<script src="{{ asset('js/other.js') }}?v1.4"></script>
@stack('assets_header')
<!-- Font Awesome -->
<!-- Font Awesome -->
<link href="{{ asset('css/all.css') }}" rel="stylesheet">

{!!$settings['before_head_tag']!!}
<style type="text/css">
    .app-box:hover .download-btn{
        right: 27px!important;
    }
    .download-btn{
        transition: .3s all ease-in-out;
        right: -60px;
    }
    .container > .row:nth-of-type(1){
    	background: #fff;
    	padding-top: 12px;
    	padding-bottom: 12px;
    }
    footer .container > .row:nth-of-type(1){
        background-color: unset!important;
        color: unset!important;
    }
    body{
    	background: #edf1f3
    }
    .nav-scroller a:last-child{
        padding-right: 8px!important
    }
    
</style>








