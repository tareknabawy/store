<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="profile" href="https://gmpg.org/xfn/11">
<meta name="robots" content="follow"/>
{!!
\MetaTag::setPath()
->setDefault(['robots' => 'follow', 'canonical' => url()->current()])
->setDefault(['og_site_name' => $settings['site_title']])
->setDefault(['og_locale' => $locale_tags[$settings['site_language']]])
->render()
!!}
@if (\Request::is("$settings[app_base]/*"))
{!! str_replace('\\', '', $schema_data->toScript()) !!}
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

<link href="{{ asset('css/all.css') }}" rel="stylesheet">
{!!$settings['before_head_tag']!!}

<style type="text/css">

body {
  background: #edf1f3;
 
}

.col-4.mb-2 {
    background: #fff;
    box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);
    }
    
    .app-box:hover .download-btn{
        right: 27px!important;
    }
.download-btn{
        transition: .3s all ease-in-out;
        right: -60px;
    }
    
.app-box:hover .download-btn-Small{
        right: 8px!important;
    }
    
.download-btn-Small{
        transition: .3s all ease-in-out;
        right: -60px;
    }
    

    


</style>

