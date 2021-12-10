{!! '<'.'?'.'xml version="1.0" encoding="UTF-8" ?>' !!}
  @php $page_url = request()->getSchemeAndHttpHost(); @endphp
  <rss version="2.0">
    <channel>
      <title>{{ $settings['site_title'] }}</title>
      <language>{{ $settings['site_language'] }}</language>
      <link>{{ $page_url }}</link>
      <description><![CDATA[{{ $settings['site_description'] }}]]></description>
      @foreach($apps as $post)
      <item>
        <title>
          <![CDATA[{!! $post->title !!}]]>
        </title>
        <pubDate>{{ $post->created_at->tz('UTC')->toRssString() }}</pubDate>
        <link>{{$page_url}}/{{ $settings['app_base'] }}/{{ $post->slug }}</link>
        <guid isPermaLink="true">{{$page_url}}/{{ $settings['app_base'] }}/{{ $post->slug }}</guid>
        <description>
          <![CDATA[{!! $post->description !!}]]>
        </description>
      </item>
      @endforeach
    </channel>
  </rss>