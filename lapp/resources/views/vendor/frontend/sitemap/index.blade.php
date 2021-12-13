@php $page_url = request()->getSchemeAndHttpHost();
echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{$page_url}}/sitemap/{{ $settings['app_base'] }}</loc>
        <loc>{{$page_url}}/sitemap/{{ $settings['page_base'] }}</loc>
        <loc>{{$page_url}}/sitemap/{{ $settings['news_base'] }}</loc>
        <loc>{{$page_url}}/sitemap/{{ $settings['category_base'] }}</loc>
        <loc>{{$page_url}}/sitemap/{{ $settings['platform_base'] }}</loc>
        <loc>{{$page_url}}/sitemap/{{ $settings['topic_base'] }}</loc>
        <loc>{{$page_url}}/sitemap/{{ $settings['tag_base'] }}</loc>
    </sitemap>
</sitemapindex>