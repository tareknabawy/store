<!DOCTYPE html>
<html lang="{{$settings['site_language']}}">
<head>
    @include('frontend::inc.head')
</head>
<body>

@include('frontend::inc.header')

@yield('content')

@include('frontend::inc.footer')

</body>
</html>