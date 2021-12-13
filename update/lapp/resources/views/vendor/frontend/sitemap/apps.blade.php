@php $page_url = request()->getSchemeAndHttpHost();
echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($apps as $app)
        <url>
            <loc>{{$page_url}}/{{ $settings['app_base'] }}/{{ $app->slug }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($app->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach
</urlset>