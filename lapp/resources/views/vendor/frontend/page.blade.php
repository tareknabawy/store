<!DOCTYPE html>
<html lang="{{$settings['site_language']}}-US">
<head>
@include('frontend::inc.head')
</head>
<script type="text/javascript"> function selectAll() { document.form1.demo.focus(); document.form1.demo.select(); } </script> 
<body> 
@include('frontend::inc.header')
@yield('content')
@include('frontend::inc.footer')
</body>
</html>