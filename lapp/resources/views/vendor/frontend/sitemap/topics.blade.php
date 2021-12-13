@php $page_url = request()->getSchemeAndHttpHost();
echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($topics as $topic)
        <url>
            <loc>{{$page_url}}/{{ $settings['topic_base'] }}/{{ $topic->slug }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($topic->updated_at)) }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>