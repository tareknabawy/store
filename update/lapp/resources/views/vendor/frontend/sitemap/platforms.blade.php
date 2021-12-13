@php $page_url = request()->getSchemeAndHttpHost();
echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($platforms as $platform)
    @php
    $page_count=ceil($platform->count/24);

    for ($x = 1; $x <= $page_count; $x++) {

    @endphp

        <url>
            <loc>{{$page_url}}/{{ $settings['platform_base'] }}/{{ $platform->slug }}@php if ( $x>1 ) { echo "?page=$x"; } @endphp</loc>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @php } @endphp
    @endforeach
</urlset>
